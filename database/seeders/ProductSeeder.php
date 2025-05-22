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
         $products = [
            [
                'name' => 'Jolly Burger',
                'price' => 49.00,
                'stock' => 50,
                'sku' => 'Burger',
                'category_name' => 'Burger',
            ],
            [
                'name' => 'Chicken Joy',
                'price' => 75.00,
                'stock' => 200,
                'sku' => 'C1',
                'category_name' => 'Chicken',
            ],
            [
                'name' => 'Palabok',
                'price' => 90.00,
                'stock' => 30,
                'sku' => 'P1',
                'category_name' => 'Pasta',
            ],
            [
                'name' => 'Gravy',
                'price' => 15.00,
                'stock' => 30,
                'sku' => 'Gravy',
                'category_name' => 'Extras',
            ],
        ];

        foreach ($products as $data) {
            $category = Category::where('name', $data['category'])->first();

            if ($category) {
                Product::create([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'sku' => $data['sku'],
                    'category_id' => $category->id,
                    'image_path' => null,
                    'description' => null,
                    'is_active' => true,
                ]);
            }
        }
    }
}
