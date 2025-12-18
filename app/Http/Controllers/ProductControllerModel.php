<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class ProductControllerModel extends Controller
{
    /**
     * Mostrar todos los productos (USANDO DB)
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);

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
        $this->authorize('viewAny', Product::class);
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
        $this->authorize('create', Product::class);
        return "Formulario para CREAR un nuevo producto";
    }

    /**
     * Almacena un recurso recién creado.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

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
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);
        $product->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado existosamente',
            'data' => $product
        ]);
    }

    public function destroy($id) 
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    public function lowStock(Request $request)
    {
        $this->authorize('viewAny', Product::class);
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