<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(5)->create();

        Category::create([
            'id' => 1,
            'name' => 'Food',
        ]);
        Category::create([
            'id' => 2,
            'name' => 'Coffee',
        ]);
        Category::create([
            'id' => 3,
            'name' => 'Non Coffee',
        ]);
        Category::create([
            'id' => 4,
            'name' => 'Snack',
        ]);
        Category::create([
            'id' => 5,
            'name' => 'Dessert',
        ]);
    }
}
