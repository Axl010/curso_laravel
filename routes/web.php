<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DBConditionsController;
use App\Http\Controllers\DBCOnditionsController as ControllersDBCOnditionsController;
use Illuminate\Support\Facades\DB;

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

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

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

    Route::get('/seed-categories', function () {
        DB::table('categories')->insert([
            [
                'name' => 'Electrónicos',
                'slug' => 'electronicos',
                'description' => 'Productos electrónicos y tecnológicos',
                'color' => '#3498db',
                'position' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
            'name' => 'Ropa',
                'slug' => 'ropa',
                'description' => 'Ropa y accesorios',
                'color' => '#e74c3c', 
                'position' => 2,
                'created_at' => now(),
                'updated_at' => now() 
            ]
        ]);

        return 'Categorías insertadas';
    });
});