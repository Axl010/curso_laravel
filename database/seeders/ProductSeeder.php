<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Lista de productos base para generar variaciones
        $products = [
            [
                'name' => 'Laptop Pro 15',
                'description' => 'Laptop de alto rendimiento para profesionales.',
                'price' => 1499.99,
            ],
            [
                'name' => 'Mouse Inalámbrico',
                'description' => 'Mouse inalámbrico ergonómico.',
                'price' => 29.99,
            ],
            [
                'name' => 'Teclado Mecánico RGB',
                'description' => 'Teclado con switches mecánicos y retroiluminación RGB.',
                'price' => 89.99,
            ],
            [
                'name' => 'Cámara HD 1080p',
                'description' => 'Cámara web para videollamadas y streaming.',
                'price' => 59.99,
            ],
            [
                'name' => 'Audífonos Over-Ear',
                'description' => 'Audífonos con aislamiento de sonido.',
                'price' => 79.99,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'sku' => strtoupper(Str::random(8)), 
                'name'        => $productData['name'],
                'description' => $productData['description'],
                'price'       => $productData['price'],
                'stock'       => rand(10, 100),
                'is_active'   => true,
                'category_id' => null,
                'expires_at'  => rand(0, 1) ? now()->addMonths(rand(1, 12)) : null,
            ]);
            
            $this->command->info("Producto '{$product['name']}' agregado exitosamente.");
        }
    }
}
