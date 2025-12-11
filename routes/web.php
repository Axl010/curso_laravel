<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllerModel;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DBCOnditionsController as ControllersDBCOnditionsController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users.list');
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

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
    Route::get('/products/low-stock/{quote}', 'lowStock')->middleware('lowStock');
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

    Route::prefix('products')->group(function () {
        // Gestión de categorías de productos
        Route::post('/{productId}/categories/attach', [ProductCategoryController::class, 'attachCategories']);
    });
});

Route::prefix('products/{product}')->group(function () {
    Route::get('/images', [ProductImageController::class, 'index']);
    Route::post('/images', [ProductImageController::class, 'store']);
    Route::get('/images/{image}', [ProductImageController::class, 'show']);
});