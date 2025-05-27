<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderShow extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->order = Order::with('orderItems.product')->findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.order-show');
    }
}
