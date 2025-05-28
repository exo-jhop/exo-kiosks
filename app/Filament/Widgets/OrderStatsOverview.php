<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{

    protected function getStats(): array
    {
        $revenues = Order::whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        return [
            Stat::make('Total Orders', Order::count())
                ->description('Total number of orders placed')
                ->descriptionIcon('heroicon-o-shopping-cart', IconPosition::Before)
                ->chart(
                    collect(range(0, 6))->map(function ($i) {
                        $date = Carbon::today()->subDays(6 - $i);
                        return Order::whereDate('created_at', $date)->count();
                    })->toArray()
                )
                ->color('primary'),

            Stat::make('Pending Orders', Order::where('status', 'pending')->count())
                ->description('Orders that are yet to be processed')
                ->descriptionIcon('heroicon-o-clock', IconPosition::Before)
                ->chart(
                    collect(range(0, 6))->map(function ($i) {
                        $date = Carbon::today()->subDays(6 - $i);
                        return Order::whereDate('created_at', $date)
                            ->where('status', 'pending')
                            ->count();
                    })->toArray()
                )
                ->color('warning'),

            Stat::make('Total Revenue', number_format(Order::sum('total_price'), 2))
                ->description('Total revenue generated from all orders')
                ->descriptionIcon('heroicon-o-currency-dollar', IconPosition::Before)
                ->chart(
                    collect(range(0, 6))->map(function ($i) {
                        $date = Carbon::today()->subDays(6 - $i);
                        return round(Order::whereDate('created_at', $date)->sum('total_price'), 2);
                    })->toArray()
                )
                ->color('success'),

            Stat::make('Products', Product::count())
                ->description('Total number of products available')
                ->descriptionIcon('heroicon-o-cube', IconPosition::Before)
                ->color('secondary'),
        ];
    }
}
