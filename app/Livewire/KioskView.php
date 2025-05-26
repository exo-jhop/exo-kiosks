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

    public $cart = [];
    public $sliders = [];

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
        $this->cart = session()->get('cart', []);
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
    }
    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    public function addToCart()
    {
        if (!$this->selectedProduct || $this->quantity < 1) {
            return;
        }

        $cart = session()->get('cart', []);

        $productId = $this->selectedProduct->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $this->quantity;
        } else {
            $cart[$productId] = [
                'id' => $this->selectedProduct->id,
                'name' => $this->selectedProduct->name,
                'price' => $this->selectedProduct->price,
                'image_path' => $this->selectedProduct->image_path,
                'quantity' => $this->quantity,
            ];
        }

        session()->put('cart', $cart);

        $this->showProductModal = false;
        $this->quantity = 1;
        $this->selectedProduct = null;

        session()->flash('message', 'Product added to cart!');
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
        return view('livewire.kiosk-view');
    }
}
