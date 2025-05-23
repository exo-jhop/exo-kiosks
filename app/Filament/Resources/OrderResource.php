<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->required()
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
                            ])
                            ->required(),
                    ])->columns(2),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->alignCenter()
                    ->date(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->sortable()
                    ->alignCenter()
            ])->filters([
                //
            ])->headerActions([
                Tables\Actions\CreateAction::make(),
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
