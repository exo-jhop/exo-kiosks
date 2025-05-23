<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class CartView extends Component
{
    public $cart = [];
    public $showPaymentModal = false;
    public $selectedPaymentMethod = null;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->cart = $cart;
    }

    public function increaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
            $this->cart = $cart;
        }
    }

    public function decreaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId]) && $cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity']--;
            session()->put('cart', $cart);
            $this->cart = $cart;
        }
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty!');
            return;
        }
        $this->showPaymentModal = true;
    }

    //     $subtotal = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    //     $order = Order::create([
    //         'total_price' => $subtotal,
    //         'subtotal' => $subtotal,
    //         'status' => 'pending',
    //         'payment_method' => 'cash',
    //         'payment_status' => 'unpaid',
    //         'order_number' => str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT),
    //     ]);

    //     foreach ($this->cart as $item) {
    //         $itemSubtotal = $item['price'] * $item['quantity'];

    //         $order->items()->create([
    //             'product_id' => $item['id'],
    //             'quantity' => $item['quantity'],
    //             'price' => $item['price'],
    //             'subtotal' => $itemSubtotal,
    //         ]);
    //     }

    //     session()->forget('cart');
    //     $this->cart = [];

    //     session()->flash('success', 'Order placed successfully!');
    //     return redirect()->route('orders.show', $order->id);
    // }
    public function confirmCheckout($paymentMethod)
    {
        $lastOrderNumber = Order::orderBy('created_at', 'desc')
            ->limit(1)
            ->pluck('order_number')
            ->first();

        $lastNumber = is_numeric($lastOrderNumber) ? (int)$lastOrderNumber : 0;

        $newNumber = ($lastNumber + 1) % 100;

        $orderNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        $this->selectedPaymentMethod = $paymentMethod;

        $subtotal = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'total_price' => $subtotal,
            'subtotal' => $subtotal,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'cash' ? 'unpaid' : 'paid',
            'order_number' => $orderNumber,
        ]);

        foreach ($this->cart as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];

            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $itemSubtotal,
            ]);
        }

        session()->forget('cart');
        $this->cart = [];
        $this->showPaymentModal = false;

        session()->flash('success', 'Order placed successfully!');
        return redirect()->route('orders.show', $order->id);
    }

    public function render()
    {
        return view('livewire.cart-view');
    }
}
