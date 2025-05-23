<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Main Meals',
                'slug' => Str::slug('main-meals'),
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Burgers & Sandwiches',
                'slug' => Str::slug('Burgers & Sandwiches'),
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sides',
                'slug' => Str::slug('Sides'),
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drinks & Desserts',
                'slug' => Str::slug('Drinks & Desserts'),
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
