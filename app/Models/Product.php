<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'is_active',
        'category_id',
        'expires_at'
    ];

    protected $caSTS = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'expire_at' => 'datetime'
    ];

     /**
     * 🔗 RELACIÓN MUCHOS A MUCHOS CON CATEGORÍAS
     * 
     * BUENAS PRÁCTICAS:
     * 1. Usar withTimestamps() si la tabla pivote tiene timestamps
     * 2. Usar withPivot() para incluir columnas adicionales
     * 3. Especificar nombre de tabla pivote si no sigue convención
     */
    public function categories(): BelongsToMany {
         return $this->belongsToMany(
            Category::class,     // Modelo relacionado
            'category_product',  // Tabla pivote (opcional si sigue convención)
            'product_id',        // FK en tabla pivote para este modelo
            'category_id',       // FK en tabla pivote para el modelo relacionado
            'id',                // Clave local (opcional)
            'id'                 // Clave local del modelo relacionado (opcional)
        )->withTimestamps()      // Incluir created_at y updated_at de la tabla pivote
         ->withPivot([           // Incluir columnas adicionales de la tabla pivote
             'is_primary', 
             'sort_order'
         ])
         ->using(CategoryProduct::class); // Modelo pivote personalizado (OPCIONAL)
    }

     /**
     * 🎯 MÉTODOS CONVENIENTES PARA TRABAJAR CON LA RELACIÓN
     */

    /**
     * Obtener categorías principales del producto
     */
    public function primaryCategories()
    {
        return $this->categories()->wherePivot('is_primary', true);
    }

    /**
     * Obtener categorías ordenadas
     */
    public function orderedCategories()
    {
        return $this->categories()->orderByPivot('sort_order', 'asc');
    }

    /**
     * Verificar si el producto pertenece a una categoría
     */
    public function hasCategory($categoryId): bool
    {
        return $this->categories()->where('categories.id', $categoryId)->exists();
    }

    /**
     * Sincronizar categorías (método muy útil)
     */
    public function syncCateogries(array $categoryIds, array $pivotData = [])
    {
        return $this->categories()->syncWithPivotValues($categoryIds, $pivotData);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
