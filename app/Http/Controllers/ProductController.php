<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'Laptop', 'price' => 1000],
            ['id' => 2, 'name' => 'Mouse', 'price' => 25],
            ['id' => 3, 'name' => 'Keyboard', 'price' => 45],
        ];

        return $products;
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return "Formulario para CREAR un nuevo producto";
    }

    /**
     * Almacena un recurso recién creado.
     */
    public function store(Request $request)
    {
        // Acceder a datos del formulario
        $name = $request->input('name');
        $price = $request->input('price');

        return "Proceso creado: $name - $$price";
    }

    /**
     * Muestra el recurso específico.
     */
    public function show($id)
    {
        return "Mostrando el producto con ID: $id";
    }

    /**
     * Muestra el formulario para editar el recurso.
     */
    public function edit($id)
    {
        return "Formulario para EDITAR el producto con ID: $id";
    }

    /**
     * Actualiza el recurso específico.
     */
    public function update(Request $request, $id) // CORREGIDO: Agregado Request $request
    {
        $name = $request->input('name');
        return "Producto $id actualizado a: $name";
    }

    /**
     * Elimina el recurso específico.
     */
    public function destroy($id) // CORREGIDO: Cambiado string $id por $id
    {
        return "Producto $id eliminado";
    }
}