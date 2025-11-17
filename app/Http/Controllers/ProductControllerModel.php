<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductControllerModel extends Controller
{
    /**
     * Mostrar todos los productos (USANDO DB)
     */
    public function index()
    {
        $products = Product::with(['category'])->active()->orderBy('created_at','desc')->get();

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'expires_at' => 'nullable|date'
        ]);

        $newProduct = Product::create($validated);

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
        $product = Product::find($id);

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

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'sku' => [
            'sometimes',
            'required',
            'string',
            'max:50',
            Rule::unique('products')->ignore($product->id)
            ],
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'expires_at' => 'nullable|date'
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado existosamente',
            'data' => $product
        ]);
    }

    public function destroy($id) 
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}