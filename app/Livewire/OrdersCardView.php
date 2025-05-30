<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class OrdersCardView extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsReady($orderId)
    {
        $order = \App\Models\Order::find($orderId);

        if ($order && $order->status !== 'completed') {
            $order->status = 'ready';
            $order->save();
        }
    }

    public function render()
    {
        $orders = Order::with('orderItems.product')
            ->where('status', 'pending')
            ->orderBy('created_at')
            ->paginate(12);


        return view('livewire.orders-card-view', [
            'orders' => $orders,
        ]);
    }
}
