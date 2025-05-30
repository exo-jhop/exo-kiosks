<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Pages\ListRecords\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
    public string $currentTab = 'all';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $statusMap = [
            'pending' => 'Pending',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'completed' => 'Completed',
            'on hold' => 'On Hold',
            'canceled' => 'Canceled',
        ];

        $tabs = [
            'all' => Tab::make('All Orders')
                ->query(fn($query) => $query->where('status', '!=', 'completed')),
        ];

        foreach ($statusMap as $status => $label) {
            $tabs[$status] = Tab::make($label)
                ->query(fn($query) => $query->where('status', $status))
                ->badge(fn() => Order::where('status', $status)->count());
        }

        return $tabs;
    }
}
