<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\SelectEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Fieldset;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        $orderNumber = $this->record?->order_number;
        return $infolist->schema([
            Section::make('Order Details')->schema([
                Grid::make(2)->schema([
                    Fieldset::make("#{$orderNumber}")->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('status')->badge(),
                                TextEntry::make('total_price')->badge()->money('PHP'),
                                TextEntry::make('payment_status')->badge(),
                                TextEntry::make('created_at')
                                    ->getStateUsing(function ($record) {
                                        $date = optional($record->created_at)->format('F j, Y g:i A');
                                        $diff = optional($record->created_at)->diffForHumans();
                                        return "{$date} ({$diff})";
                                    })
                                    ->badge(),
                            ])
                            ->columns(3),
                    ]),
                ]),
            ]),
        ]);
    }
}
