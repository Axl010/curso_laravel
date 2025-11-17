<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllerModel;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DBCOnditionsController as ControllersDBCOnditionsController;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/{id}', [PostController::class, 'show'])->where('id', '[0-9]+');

// 4. Página "about"
Route::get('/about', function () {
    return 'Acerca de nosotros';
})->name('about');

// 5. Grupo de rutas de contacto
Route::prefix('contacto')->group(function () {
    Route::get('/', function () {
        return 'Formulario de contacto';
    })->name('contacto.form');

    Route::post('/enviar', function () {
        return 'Mensaje enviado';
    })->name('contacto.enviar');
});

// RUTA DE RECURSOS
// Una sola línea crea 7 rutas:
// Route::resource('products', ProductController::class);
//  URL	                Método      Controlador	    Descripción
//  /products	        GET	        index()	        Listar todos
//  /products/create    GET	        create()	    Formulario crear
//  /products	        POST	    store()	        Guardar nuevo
//  /products/{id}	    GET	        show()	        Mostrar uno
//  /products/{id}/edit	GET	        edit()	        Formulario editar
//  /products/{id}	    PUT/PATCH	update()	    Actualizar
//  /products/{id}	    DELETE	    destroy()	    Eliminar

Route::controller(ProductControllerModel::class)->group(function () {
    Route::get('/products', 'index');
    Route::post('/products', 'store');
    Route::get('/products/active', 'activeProducts');
    Route::get('/products/low-stock', 'lowStock');
    Route::get('/products/search', 'search');
    Route::get('/products/{id}', 'show');
    Route::put('/products/{id}', 'update');
    Route::delete('/products/{id}', 'destroy');
});

Route::get('users', [UserController::class, 'index']);

// Test de conexion BD
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexion a BD exitosa.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Practica de condiciones con DB FACADES
Route::prefix('db')->controller(ControllersDBCOnditionsController::class)->group(function() {
    Route::get('/basic', 'whereBasic');
    Route::get('/andOr', 'whereAndOr');
    Route::get('/lista', 'where');
    Route::get('/whereDate', 'whereDate');

    // Ejercicio
    Route::get('/practice', 'practiceDB');

    Route::get('/seed', function () {
        // Crear categorías
        $electronica = Category::create([
            'name' => 'Electrónicos',
            'description' => 'Productos electrónicos y tecnológicos',
            'color' => '#3498db'
        ]);

        $ropa = Category::create([
            'name' => 'Ropa',
            'description' => 'Ropa y accesorios',
            'color' => '#e74c3c'
        ]);

        $hogar = Category::create([
            'name' => 'Hogar', 
            'description' => 'Productos para el hogar',
            'color' => '#2ecc71'
        ]);

        // Crear productos usando relaciones
        $electronica->products()->createMany([
            [
                'name' => 'iPhone 15 Pro',
                'sku' => 'IPH15PRO-256',
                'description' => 'iPhone 15 Pro 256GB Titanio Natural',
                'price' => 1299.99,
                'stock' => 25,
                'is_active' => true,
                'expires_at' => now()->addYears(2)
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'sku' => 'SGS24-128', 
                'description' => 'Samsung Galaxy S24 128GB 5G',
                'price' => 899.99,
                'stock' => 18,
                'is_active' => true,
                'expires_at' => now()->addYears(2)
            ]
        ]);

        $ropa->products()->createMany([
            [
                'name' => 'Camiseta Básica Negra',
                'sku' => 'CAM-BAS-NEG-M',
                'description' => 'Camiseta de algodón 100% básica color negro',
                'price' => 19.99,
                'stock' => 50,
                'is_active' => true,
                'expires_at' => null
            ],
            [
                'name' => 'Jeans Slim Fit',
                'sku' => 'JEANS-SLIM-32',
                'description' => 'Jeans slim fit color azul oscuro', 
                'price' => 49.99,
                'stock' => 22,
                'is_active' => true,
                'expires_at' => null
            ]
        ]);

        $hogar->products()->createMany([
            [
                'name' => 'Juego de Sábanas Queen',
                'sku' => 'SAB-QUEEN-AZUL',
                'description' => 'Juego de sábanas de algodón tamaño queen color azul',
                'price' => 59.99,
                'stock' => 30,
                'is_active' => true,
                'expires_at' => null
            ],
            [
                'name' => 'Set de Utensilios de Cocina',
                'sku' => 'UTENS-KITCH-25',
                'description' => 'Set de 25 piezas de utensilios de cocina antiadherentes',
                'price' => 79.99,
                'stock' => 8,
                'is_active' => true,
                'expires_at' => now()->addYears(5)
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Datos de prueba insertados usando Eloquent',
            'data' => [
                'categories' => Category::count(),
                'products' => Product::count(),
                'categories_with_products' => Category::withCount('products')->get()
            ]
        ]);
    });
});