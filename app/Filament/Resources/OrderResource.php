<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;
use App\Filament\Widgets\OrderAlert;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Support\HtmlString;
use Illuminate\Support\HtmlString as SupportHtmlString;

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
                                                'processing' => 'Processing',
                                                'on_hold' => 'On Hold',
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
                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('mark_paid')
                                                ->label('Mark as Paid')
                                                ->icon('heroicon-m-check-circle')
                                                ->color('success')
                                                ->action(function (array $data, $record) {
                                                    $record->update(['payment_status' => 'paid']);
                                                })
                                                ->requiresConfirmation()
                                                ->visible(fn($record) => $record?->payment_status !== 'paid'),

                                            Forms\Components\Actions\Action::make('complete_order')
                                                ->label('Complete Order')
                                                ->icon('heroicon-m-check-badge')
                                                ->color('success')
                                                ->action(function (array $data, $record) {
                                                    $record->update([
                                                        'status' => 'completed',
                                                        'payment_status' => 'paid'
                                                    ]);
                                                })
                                                ->requiresConfirmation()
                                                ->visible(fn($record) => $record?->status !== 'completed'),

                                            Forms\Components\Actions\Action::make('cancel_order')
                                                ->label('Cancel Order')
                                                ->icon('heroicon-m-x-circle')
                                                ->color('danger')
                                                ->action(function (array $data, $record) {
                                                    $record->update(['status' => 'canceled']);
                                                })
                                                ->requiresConfirmation()
                                                ->visible(fn($record) => $record?->status !== 'canceled'),
                                        ])
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

                BadgeColumn::make('payment_method')
                    ->label('Method')
                    ->sortable()
                    ->alignCenter()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->since()
                    ->badge(),

            ])->filters([])->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])->actions([
                Tables\Actions\ViewAction::make(),

            ])->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Process')
                    ->icon('heroicon-o-cog')
                    ->action(function (Order $record) {
                        $record->status = 'processing';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('primary'),
                Tables\Actions\EditAction::make(),

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
}
