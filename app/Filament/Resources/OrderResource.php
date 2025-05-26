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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Details')
                    ->columns(2)
                    ->description(fn($record) => $record?->order_number ? "Order #{$record->order_number}" : null)
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->required()
                            ->disabled(true)
                            ->unique(Order::class, 'order_number', ignoreRecord: true),
                        Forms\Components\TextInput::make('total_price')
                            ->required()
                            ->numeric(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'on_hold' => 'On Hold',
                                'completed' => 'Completed',
                                'canceled' => 'Canceled',
                            ]),
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                            ])
                            ->default('cash')
                            ->required(),
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'unpaid' => 'Unpaid',
                            ])
                            ->default('unpaid')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('order_number')
                    ->sortable()
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable()
                    ->alignCenter()
                    ->money('PHP'),
                SelectColumn::make('payment_status')
                    ->options([
                        'pending' => 'paid',
                        'unpaid' => 'unpaid',
                    ])
                    ->sortable()
                    ->alignCenter(),

                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->getStateUsing(function ($record) {
                        $date = optional($record->created_at)->format('g:i A');
                        $diff = optional($record->created_at)->diffForHumans();
                        return "{$date} ({$diff})";
                    })
                    ->badge(),
            ])->filters([
                //
            ])->headerActions([
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
                        // Logic to process the order
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
