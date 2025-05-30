<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class OrdersCardView extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsPreparing($orderId)
    {
        $order = \App\Models\Order::find($orderId);

        if ($order && $order->status !== 'completed') {
            $order->status = 'preparing';
            $order->save();
        }
    }

    public function markAsReady($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->status === 'preparing') {
            $order->status = 'ready';
            $order->save();
        }
    }

    public function render()
    {
        $orders = Order::with('orderItems.product')
            ->whereIn('status', ['pending', 'preparing'])
            ->where('payment_status', 'paid')
            ->orderBy('created_at')
            ->paginate(12);


        return view('livewire.orders-card-view', [
            'orders' => $orders,
        ]);
    }
}
