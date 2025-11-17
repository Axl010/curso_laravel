<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * 🔗 RELACIÓN UNO A MUCHOS (INVERSA)
     * Un producto pertenece a una categoría
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
