<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * ASIGNAR CATEGORÍAS A UN PRODUCTO
     */

    public function attachCategories(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'is_primary' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0'
        ]);

        // MÉTODO 1: Attach (agregar sin eliminar existentes)
        $product->categories()->attach($validated['category_ids'], [
            'is_primary' => $validated['is_primary'] ?? false,
            'sort_order' => $validated['sort_order'] ?? 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría asignada al producto',
            'data' => $product->load('categories')
        ]);
    }
}
