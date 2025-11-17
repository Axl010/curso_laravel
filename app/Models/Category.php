<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'color',
        'is_active',
        'parent_id',
    ];

    /**
     * RELACIÓN UNO A MUCHOS
     * Una categoría tiene muchos productos
     */
    public function products(): HasMany 
    {
        return $this->hasMany(Product::class);
    }
}
