<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Section::make(fn($record) => $record?->order_number ? "Order Number - #{$record->order_number}" : 'Order Details')
                            ->description('Manage the details of this order')
                            ->icon('heroicon-o-banknotes')
                            ->iconColor('success')
                            ->collapsible()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('total_price')
                                            ->label('Total Amount')
                                            ->required()
                                            ->numeric()
                                            ->prefix('₱')
                                            ->prefixIcon('heroicon-m-currency-dollar')
                                            ->extraAttributes([
                                                'class' => 'text-lg font-semibold'
                                            ])
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->placeholder('0.00'),
                                        Select::make('payment_method')
                                            ->label('Payment Method')
                                            ->options([
                                                'cash' => 'Cash Payment',
                                                'card' => 'Credit/Debit Card',
                                                'gcash' => 'GCash',
                                                'paymaya' => 'PayMaya',
                                                'bank_transfer' => 'Bank Transfer',
                                            ])
                                            ->default('cash')
                                            ->required()
                                            ->prefixIcon('heroicon-m-credit-card')
                                            ->native(false)
                                            ->searchable(),
                                        Select::make('status')
                                            ->label('Order Status')
                                            ->options([
                                                'pending' => 'Pending',
                                                'preparing' => 'Preparing',
                                                'ready' => 'Ready',
                                                'on hold' => 'On Hold',
                                                'completed' => 'Completed',
                                                'canceled' => 'Canceled',
                                            ])
                                            ->prefixIcon('heroicon-m-clock')
                                            ->native(false)
                                            ->searchable()
                                            ->suffixAction(
                                                Forms\Components\Actions\Action::make('status_info')
                                                    ->icon('heroicon-m-information-circle')
                                                    ->color('gray')
                                                    ->tooltip('View status descriptions')
                                                    ->modalSubmitAction(false)
                                                    ->modalCancelActionLabel('Close')
                                            ),

                                        Select::make('payment_status')
                                            ->label('Payment Status')
                                            ->options([
                                                'paid' => 'Paid',
                                                'unpaid' => 'Unpaid',
                                                'partial' => 'Partially Paid',
                                                'refunded' => 'Refunded',
                                            ])
                                            ->default('unpaid')
                                            ->required()
                                            ->prefixIcon('heroicon-m-banknotes')
                                            ->native(false),
                                    ])
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                BadgeColumn::make('order_number')
                    ->label('Order No.')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->color('info'),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('PHP')
                    ->sortable()
                    ->alignCenter()
                    ->color('success')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'info' => 'preparing',
                        'warning' => 'on_hold',
                        'success' => 'completed',
                        'danger' => 'canceled',
                    ]),


                BadgeColumn::make('payment_method')
                    ->label('Method')
                    ->sortable()
                    ->alignCenter()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->since()
                    ->badge(),

            ])->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_at')
                            ->label('Order Date')
                            ->default(Carbon::today()),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['created_at'],
                            fn($q) => $q->whereDate('created_at', $data['created_at'])
                        );
                    }),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                    ]),

            ])->headerActions([])->actions([
                Tables\Actions\ViewAction::make(),

            ])->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('Process')
                    ->icon('heroicon-o-cog')
                    ->modalHeading('Checkout')
                    ->modalWidth('sm')
                    ->visible(function (Order $record, $livewire) {
                        if ($livewire->activeTab === 'all') {
                            return $record->status !== 'completed';
                        }

                        return $record->status === 'pending';
                    })
                    ->form([
                        Placeholder::make('items')
                            ->label('Items')
                            ->content(fn(Order $record) => new HtmlString(
                                view('components.order-items', ['order' => $record])->render()
                            )),

                        TextInput::make('amount_paid')
                            ->label('Amount Paid')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->visible(fn(Order $record) => $record->status !== 'completed'),

                        Hidden::make('total')
                            ->default(fn(Order $record) => $record->orderItems->sum(
                                fn($item) => $item->quantity * $item->price
                            )),

                        Placeholder::make('change')
                            ->label('Change')
                            ->content(function (Get $get) {
                                $amountPaid = floatval($get('amount_paid') ?? 0);
                                $total = floatval($get('total') ?? 0);
                                $change = max(0, $amountPaid - $total);

                                return new HtmlString(
                                    '<span class="text-primary-600 text-xl font-semibold">₱ ' . number_format($change, 2) . '</span>'
                                );
                            })
                            ->visible(fn(Order $record) => $record->status !== 'completed'),
                    ])
                    ->action(function (array $data, Order $record) {
                        if ($record->status === 'completed' || $record->status === 'preparing') {
                            return;
                        }

                        $total = $record->orderItems->sum(fn($item) => $item->quantity * $item->price);
                        $amountPaid = floatval($data['amount_paid']);

                        if ($amountPaid < $total) {
                            Notification::make()
                                ->title('Insufficient amount paid.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'payment_status' => 'Paid',
                        ]);

                        Notification::make()
                            ->title('Order processed successfully')
                            ->success()
                            ->send();
                    })
                    ->modalSubmitActionLabel('Close')
                    ->modalCancelAction(false)
                    ->color('primary'),

                Tables\Actions\EditAction::make()
                    ->visible(
                        fn(Order $order, $livewire) =>
                        $livewire->activeTab === 'all' || in_array($order->status, ['pending'])
                    ),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/view/{record}'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('created_at', Carbon::today())->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of orders';
    }
}
