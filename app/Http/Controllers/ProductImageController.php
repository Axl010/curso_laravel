<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Listar todas las imágenes de un producto.
     */
    public function index($productId)
    {
        $product = Product::with('images')->find($productId);

        if (!$product) {
            return response()->json([
                'success' => true,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product->images
        ]);
    }

    /**
     * Subir una o varias imágenes a un producto.
     */
    public function store(Request $request, $productId)
    {
        $product = Product::fin($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $request->validate([
            'images.*' =>  'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $uploadedImages = [];

        foreach ($request->file('images') as $file) {
            $path = $file->store('products/' . $productId, 'public');

            $img = $product->images()->create([
                'path' => $path
            ]);

            $uploadedImages[] = $img;
        }

        return response()->json([
            'success' => true,
            'message' => 'Imágenes subidas con éxito',
            'data' => $uploadedImages
        ], 201);
    }

     /**
     * Mostrar una imagen específica de un producto.
     */
    public function show($productId, $imageId)
    {
        $image = Image::where('imageable_id', $productId)
                      ->where('imageable_type', Product::class)
                      ->find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $image
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
