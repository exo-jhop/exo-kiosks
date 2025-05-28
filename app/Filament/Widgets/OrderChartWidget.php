<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Daily Orders This Month';
    protected static ?string $pollingInterval = '10s';
    protected int | string | array $columnSpan = 2;
    protected static null|int $sort = 2;

    protected function getData(): array
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $orders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $daysInMonth = $startOfMonth->daysInMonth;
        $dailyCounts = collect(range(1, $daysInMonth))->map(function ($day) use ($orders, $startOfMonth) {
            $date = $startOfMonth->copy()->day($day)->toDateString();
            return $orders[$date] ?? 0;
        });

        $labels = collect(range(1, $daysInMonth))->map(function ($day) {
            return $day;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $dailyCounts->values(),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
