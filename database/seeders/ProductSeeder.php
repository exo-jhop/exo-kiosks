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
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 10.99,
                'description' => 'A delicious Jolly Combo meal with chicken, rice, and gravy.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cheeseburger',
                'slug' => Str::slug('cheeseburger'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Burgers & Sandwiches')->first()->id,
                'price' => 5.99,
                'description' => 'A delicious cheeseburger with lettuce, tomato, and cheese.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French Fries',
                'slug' => Str::slug('french-fries'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Sides')->first()->id,
                'price' => 2.99,
                'description' => 'Crispy golden french fries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chocolate Sundae',
                'slug' => Str::slug('chocolate-sundae'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Drinks & Desserts')->first()->id,
                'price' => 3.99,
                'description' => 'A delicious chocolate sundae with whipped cream and a cherry on top.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coca-Cola',
                'slug' => Str::slug('coca-cola'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Drinks & Desserts')->first()->id,
                'price' => 1.99,
                'description' => 'A refreshing Coca-Cola.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chicken Nuggets',
                'slug' => Str::slug('chicken-nuggets'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 4.99,
                'description' => 'Crispy chicken nuggets served with dipping sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spicy Chicken Sandwich',
                'slug' => Str::slug('spicy-chicken-sandwich'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 6.99,
                'description' => 'A spicy chicken sandwich with lettuce and mayo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Garden Salad',
                'slug' => Str::slug('garden-salad'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 4.49,
                'description' => 'A fresh garden salad with mixed greens and vinaigrette.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vanilla Milkshake',
                'slug' => Str::slug('vanilla-milkshake'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Burgers & Sandwiches')->first()->id,
                'price' => 3.49,
                'description' => 'A creamy vanilla milkshake topped with whipped cream.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apple Pie',
                'slug' => Str::slug('apple-pie'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Sides')->first()->id,
                'price' => 2.49,
                'description' => 'A warm apple pie with a flaky crust.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fish Fillet',
                'slug' => Str::slug('fish-fillet'),
                'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/200/300',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 8.99,
                'description' => 'A crispy fish fillet served with tartar sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
