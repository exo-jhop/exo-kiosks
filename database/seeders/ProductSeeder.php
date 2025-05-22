<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; $i++) {
                Product::create([
                    'name' => "Product {$i} in {$category->name}",
                    'slug' => Str::slug("Product {$i} in {$category->name}"),
                    'image_path' => null,
                    'description' => "Description for Product {$i} in {$category->name}",
                    'price' => rand(100, 1000),
                    'category_id' => $category->id,
                    'sku' => "SKU-{$i}-{$category->id}",
                    'stock' => rand(1, 100),
                    'is_active' => true,
                ]);
            }
        }
    }
}
