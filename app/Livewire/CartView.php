<?php

namespace App\Livewire;

use Livewire\Component;

class CartView extends Component
{
    public $cart = [];

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

    public function render()
    {
        return view('livewire.cart-view');
    }
}
