<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    protected static ?string $recordTitleAttribute = 'product_name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        $panel = Filament::getCurrentPanel();
        $isKitchen = $panel && $panel->getId() === 'kitchen';

        return $table
            ->recordTitleAttribute('orderItem')
            ->columns([
                ImageColumn::make('product.image_path')
                    ->label('Product Image')
                    ->alignCenter()
                    ->sortable()
                    ->url(fn($record) => $isKitchen ? null : EditProduct::getUrl(['record' => $record->product_id]))
                    ->square()
                    ->extraImgAttributes(['class' => 'rounded-md shadow-sm']),

                TextColumn::make('product.name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => $isKitchen ? null : EditProduct::getUrl(['record' => $record->product_id]))
                    ->toggleable()
                    ->wrap(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->badge()
                    ->colors([
                        'primary',
                        'warning' => fn($state) => $state < 5,
                    ])
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->badge()
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('PHP')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
