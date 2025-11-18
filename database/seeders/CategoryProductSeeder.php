<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $products = Product::all();

        foreach ($products as $product) {
            // Asignar una categoría aleatoria
            $category = $categories->random();

            $product->categories()->attach($category->id);

            $this->command->info("Producto '{$product->name}' asignado a la categoría '{$category->name}'.");
        }
    }
}
