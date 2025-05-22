<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class KioskView extends Component
{
    public $categories = [];
    public $selectedCategoryId = null;
    public $products = [];
    public $selectedCategoryName = 'All Products';

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->loadProducts();
    }

    public function loadProducts()
    {
        if ($this->selectedCategoryId) {
            $category = Category::find($this->selectedCategoryId);
            $this->selectedCategoryName = $category->name;
            $this->products = $category->products;
        } else {
            $this->selectedCategoryName = 'All Products';
            $this->products = Product::all();
        }
    }

    public function render()
    {
        return view('livewire.kiosk-view');
    }
}
