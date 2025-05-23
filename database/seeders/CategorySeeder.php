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
                'image_path' => 'https://img.freepik.com/premium-vector/silhouette-illustration-main-course-dish-fried-chicken_612398-109.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Burgers & Sandwiches',
                'slug' => Str::slug('Burgers & Sandwiches'),
                'image_path' => 'https://media.istockphoto.com/id/1004591262/vector/burger-with-crown-logo-illustration.jpg?s=612x612&w=0&k=20&c=LlzCALcTkHECx7O7QGFRJG7HLeleeVgb0V_2n7W0BU4=',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sides',
                'slug' => Str::slug('Sides'),
                'image_path' => 'https://png.pngtree.com/element_pic/00/16/08/0657a4e9b377d0d.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drinks & Desserts',
                'slug' => Str::slug('Drinks & Desserts'),
                'image_path' => 'https://png.pngtree.com/png-clipart/20230922/original/pngtree-fresh-juice-logo-images-illustration-abstract-vector-food-vector-png-image_12525690.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
