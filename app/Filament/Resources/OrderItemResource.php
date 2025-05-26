<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Filament\Resources\OrderItemResource\RelationManagers;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders';

    protected static ?string $navigationParentItem = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Item Details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'order_number')
                            ->required()
                            ->label('Order Number')
                            ->searchable()
                            ->placeholder('Select Order Number')
                            ->prefixIcon('heroicon-o-hashtag'),

                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Product')
                            ->prefixIcon('heroicon-o-cube')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $product = Product::find($state);
                                $set('price', $product ? $product->price : 0);
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->label('Quantity')
                            ->minValue(1)
                            ->step(1)
                            ->prefixIcon('heroicon-o-calculator')
                            ->placeholder('Enter quantity'),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->label('Price (₱)')
                            ->step(0.01)
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-currency-dollar')
                            ->placeholder('Enter price'),

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->required()
                            ->label('Subtotal (₱)')
                            ->step(0.01)
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-calculator')
                            ->placeholder('Subtotal will be calculated'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('order.order_number')
            ->columns([
                Tables\Columns\ImageColumn::make('product.image_path')
                    ->label('Product Image')
                    ->searchable()
                    ->alignCenter()
                    ->sortable()
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('PHP')
                    ->sortable(),

            ])->filters([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
