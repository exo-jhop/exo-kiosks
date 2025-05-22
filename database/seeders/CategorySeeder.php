<?php

namespace Database\Seeders;

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
        $categories = [
            'Main Meals',
            'Burgers & Sandwiches',
            'Sides',
            'Drinks & Desserts',
            'Value Meals / Combo Meals',
            'Kids Meals',
            'Group Meals / Bucket Treats',
            'Mix & Match / Build Your Own Meal',

        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
