<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_product';

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * MÉTODOS ADICIONALES PARA LÓGICA DE NEGOCIO EN LA RELACIÓN
     */
    
    /**
     * Marcar como categoría principal
     */
    public function markAsPrimary()
    {
        $this->update(['is_primary' => true]);
    }

    /**
     * Actualizar orden
     */
    public function updateOrder($order)
    {
        $this->update(['sort_order' => $order]);
    }
}
