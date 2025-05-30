<?php

namespace App\Filament\Kitchen\Resources;

use App\Filament\Kitchen\Pages\OrdersCardView;
use App\Filament\Kitchen\Resources\OrderResource\Pages;
use App\Filament\Kitchen\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Mark as Completed')
                    ->icon('heroicon-o-check'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
