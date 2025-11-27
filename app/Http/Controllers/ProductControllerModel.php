<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Container\Attributes\Log;
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
        $products = Product::with(['category'])->orderBy('created_at','desc')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    
    /**
     * Mostrar un producto específico CON TODAS SUS RELACIONES
     */
    public function byCategory($categoryId) {
        $products = Product::with('category')
                    ->where('category_id', $categoryId)
                    ->active()
                    ->inStock()
                    ->get();
        
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
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        Log::info('Producto creado', ['id' => $product->id, 'sku' => $product->sku]);

        return response()->json([
            'succcess' => true,
            'message' => 'Porducto creado exitosamente',
            'data' => $product
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

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->update($request->validated());

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

    public function lowStock(Request $request)
    {
        $minStock = $request->min_stock ?? 5;

        $products = Product::where('stock', '<=', $minStock)
                            ->orderBy('stock', 'asc')
                            ->get();

        return response()->json([
            'success' => true,
            'min_stock' => $minStock,
            'data' => $products
        ]);
    }
}