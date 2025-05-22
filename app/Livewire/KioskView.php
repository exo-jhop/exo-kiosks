<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class KioskView extends Component
{
    public $categories = [];
    public $selectedCategoryId = null;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function render()
    {
        return view('livewire.kiosk-view');
    }
}
