<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class KioskView extends Component
{
    public $categories = [];
    public $selectedCategoryId = null;
    public Collection $products;

    public $selectedCategoryName = 'All Products';
    public $selectedCategoryImagePath;

    public $showProductModal = false;
    public $selectedProduct;
    public $quantity = 1;
    public $quantities = [];

    public $cart = [];
    public $cartCount = 0;
    public $sliders = [];

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
        $this->cart = session()->get('cart', []);
        $this->updateCartCount();
        $this->sliders = Slider::where('is_active', true)->get();
    }

    public function openProductModal($productId)
    {
        Log::debug('Products:', $this->products->toArray());

        $product = $this->products->firstWhere('id', $productId);

        if ($product) {
            $this->selectedProduct = $product;
            $this->quantity = 1;
            $this->showProductModal = true;
        } else {
            Log::warning("Product with ID {$productId} not found in products collection.");
            $this->selectedProduct = null;
            $this->showProductModal = false;
        }
    }

    public function closeProductModal()
    {
        $this->showProductModal = false;
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->selectedProduct = null;
        $this->showProductModal = false;
        $this->loadProducts();
    }

    public function loadProducts()
    {
        if ($this->selectedCategoryId) {
            $category = Category::with('products')->find($this->selectedCategoryId);
            Log::debug('Category with products:', [
                'category_id' => $this->selectedCategoryId,
                'products_count' => $category ? $category->products->count() : 'null',
            ]);
            $this->selectedCategoryName = $category->name ?? 'Category Not Found';
            $this->selectedCategoryImagePath = $category->image_path ?? null;
            $this->products = $category ? $category->products : collect();
        } else {
            $this->selectedCategoryName = 'All Products';
            $this->selectedCategoryImagePath = null;
            $this->products = Product::all();
        }
        foreach ($this->products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }
    }

    public function increaseQuantity($productId)
    {
        if (!isset($this->quantities[$productId])) {
            $this->quantities[$productId] = 1;
        } else {
            $this->quantities[$productId]++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->quantities[$productId]) && $this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function updateCartCount()
    {
        $cart = session()->get('cart', []);
        $this->cartCount = count($cart);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) return;

        $quantityToAdd = $this->quantities[$productId] ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantityToAdd;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image_path' => $product->image_path,
                'quantity' => $quantityToAdd,
            ];
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->updateCartCount();

        session()->flash('message', 'Product added to cart!');
    }


    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->updateCartCount();
    }

    public function render()
    {
        return view('livewire.kiosk-view');
    }
}
