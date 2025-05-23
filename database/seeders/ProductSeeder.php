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
                'image_path' => 'https://cdn-menu-us-east-1.tillster.com/jb-ph/560b1b75-fe22-4023-8ec1-33d1287d2b72.png',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 10.99,
                'description' => 'A delicious Jolly Combo meal with chicken, rice, and gravy.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cheeseburger',
                'slug' => Str::slug('cheeseburger'),
                'image_path' => 'https://live.staticflickr.com/3008/2867596104_20c5cb4051_b.jpg',
                'category_id' => Category::where('name', 'Burgers & Sandwiches')->first()->id,
                'price' => 5.99,
                'description' => 'A delicious cheeseburger with lettuce, tomato, and cheese.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French Fries',
                'slug' => Str::slug('french-fries'),
                'image_path' => 'https://live.staticflickr.com/3260/2867596990_3986c9ecdc_z.jpg',
                'category_id' => Category::where('name', 'Sides')->first()->id,
                'price' => 2.99,
                'description' => 'Crispy golden french fries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chocolate Sundae',
                'slug' => Str::slug('chocolate-sundae'),
                'image_path' => 'https://queen.jollibee.com.ph/2022/01/Chocolate-Sundae-Twirl.png',
                'category_id' => Category::where('name', 'Drinks & Desserts')->first()->id,
                'price' => 3.99,
                'description' => 'A delicious chocolate sundae with whipped cream and a cherry on top.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iced Tea',
                'slug' => Str::slug('Iced Tea'),
                'image_path' => 'https://www.jollibee.com.bn/assets/images/products/64/300x300/lemon-tea.jpg',
                'category_id' => Category::where('name', 'Drinks & Desserts')->first()->id,
                'price' => 1.99,
                'description' => 'A refreshing Iced Tea.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chicken Nuggets',
                'slug' => Str::slug('chicken-nuggets'),
                'image_path' => 'https://www.regaloph.com/images/products/large_3637_new2024_004.png',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 4.99,
                'description' => 'Crispy chicken nuggets served with dipping sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spicy Chicken Sandwich',
                'slug' => Str::slug('spicy-chicken-sandwich'),
                'image_path' => 'https://jollibeemenu.us/wp-content/uploads/2024/08/original-chicken-sandwich.webp',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 6.99,
                'description' => 'A spicy chicken sandwich with lettuce and mayo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Garden Salad',
                'slug' => Str::slug('garden-salad'),
                'image_path' => 'https://pinoycupidgifts.com/wp-content/uploads/2022/09/Mango-Kani-Salad.jpg',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 4.49,
                'description' => 'A fresh garden salad with mixed greens and vinaigrette.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vanilla Milkshake',
                'slug' => Str::slug('vanilla-milkshake'),
                'image_path' => 'https://www.mygingergarlickitchen.com/wp-content/rich-markup-images/1x1/1x1-vanilla-milkshake.jpg',
                'category_id' => Category::where('name', 'Burgers & Sandwiches')->first()->id,
                'price' => 3.49,
                'description' => 'A creamy vanilla milkshake topped with whipped cream.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apple Pie',
                'slug' => Str::slug('apple-pie'),
                'image_path' => 'https://cdn.jwplayer.com/v2/media/sC8av9Hc/thumbnails/oynyDlfN.jpg?width=1280',
                'category_id' => Category::where('name', 'Sides')->first()->id,
                'price' => 2.49,
                'description' => 'A warm apple pie with a flaky crust.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fish Fillet',
                'slug' => Str::slug('fish-fillet'),
                'image_path' => 'https://www.licious.in/blog/wp-content/uploads/2020/12/Fried-Fish-Fillet-1.jpg',
                'category_id' => Category::where('name', 'Main Meals')->first()->id,
                'price' => 8.99,
                'description' => 'A crispy fish fillet served with tartar sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
