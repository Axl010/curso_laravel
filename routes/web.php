<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function() {
    return 'Bienvenido al Blog';
})->name('home');

Route::get('/posts', function () {
    return 'Lista de todos los posts';
});

Route::get('/posts/{id}', function ($id) {
    return "Mostrando post ID: $id";
})->where('id', '[0-9]+')->name('posts.show');

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
Route::resource('products', ProductController::class);