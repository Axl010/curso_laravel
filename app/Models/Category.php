<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'color', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

     /**
     * 🔗 RELACIÓN MUCHOS A MUCHOS CON PRODUCTOS
     */
    public function products(): BelongsToMany 
    {
        return $this->belongsToMany(Product::class, 'category_product')
                    ->withTimestamps()
                    ->withPivot(['is_primary', 'sort_order'])
                    ->wherePivot('is_primary', true); // Solo productos principales en esta categoría
    }

    public function allProducts()
    {
        return $this->belongsToMany(Product::class, 'category_product')
                    ->withTimestamps()
                    ->withPivot(['is_primary', 'sort_order']);
    }

    /**
     * Contar productos en la categoría
     */
    public function productsCount()
    {
        return $this->allProducts()->count();
    }

    /**
     * Productos activos en la categoría
     */
    public function activeProducts()
    {
        return $this->products()->where('products.is_active', true);
    }

    // Relación Polimórfica
    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }
}
