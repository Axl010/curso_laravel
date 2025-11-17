<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductControllerDB extends Controller
{
    /**
     * Mostrar todos los productos (USANDO DB)
     */
    public function index()
    {
        $products = DB::table('products')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
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
        $productId = DB::table('products')->insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $newProduct = DB::table('products')->where('id', $productId)->first();

        return response()->json([
            'succcess' => true,
            'message' => 'Porducto creado exitosamente',
            'data' => $newProduct
        ], 201);
    }

    /**
     * Mostrar un producto específico (USANDO DB)
     */
    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function update(Request $request, $id) {
        $affected = DB::table('products')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'is_active' => $request->is_active,
                'updated_at' => now()
            ]);
        
        if ($affected === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $updatedProduct = DB::table('products')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado existosamente',
            'dataa' => $updatedProduct
        ]);
    }

    public function destroy($id) {
        dump($id);
        $affected = DB::table('products')
            ->where('id', $id)
            ->delete();
        
        if ($affected === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}