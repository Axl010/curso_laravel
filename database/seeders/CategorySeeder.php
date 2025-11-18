<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $categories = [
            [
                'name' => 'Electrónicos',
                'description' => 'Productos de tecnología',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Prendas y accesorios',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Productos para el hogar',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
            $this->command->info("Categoría '{$category['name']}' agregada exitosamente.");
        }
    }
}
