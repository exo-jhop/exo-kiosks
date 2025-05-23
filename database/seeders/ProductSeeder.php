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
        Product::insert([
            [
                'name' => 'Jolly Combo',
                'slug' => Str::slug('jolly-combo'),
                'image_path' => null,
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 10.99,
                'description' => 'A delicious Jolly Combo meal with chicken, rice, and gravy.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cheeseburger',
                'slug' => Str::slug('cheeseburger'),
                'image_path' => null,
                'category_id' => Category::where('name', 'Burgers & Sandwiches')->first()->id,
                'price' => 5.99,
                'description' => 'A delicious cheeseburger with lettuce, tomato, and cheese.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French Fries',
                'slug' => Str::slug('french-fries'),
                'image_path' => null,
                'category_id' => Category::where('name', 'Sides')->first()->id,
                'price' => 2.99,
                'description' => 'Crispy golden french fries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
