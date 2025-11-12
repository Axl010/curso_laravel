<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DBCOnditionsController extends Controller
{
    public function whereBasic()
    {
        // WHERE price = 79.99
        $basic = DB::table('products')
            ->where('price', 79.99)
            ->get();

        // WHERE stock <= 20
        $lowStock = DB::table('products')
            //->where('stock', '!=', 10),
            ->where('stock', '<', 20)
            ->get();
            
        // WHERE name LIKE '%lap%' (contiene 'lap')
        $containsLap = DB::table('products')
            ->where('name', 'LIKE', '%lap%')  // lap% OR %lap
            ->get();

        // WHERE price BETWEEN 50 AND 100
        $whereBetween = DB::table('products')
            ->whereBetween('price', [50, 100])
            ->get();

        // WHERE price NOT BETWEEN 50 AND 100
        $whereNotBetween = DB::table('products')
            ->whereNotBetween('price', [50, 100])
            ->get();
        
        return [
            'basic' => $basic,
            'lowStock' => $lowStock,
            'containLap' => $containsLap,
            'whereBetween' => $whereBetween,
            'whereNotBetween' => $whereNotBetween,
        ];
    }
    
    public function whereAndOr() {
        // WHERE price > 10 AND stock > 50
        $conditionAnd = DB::table('products')
            ->where('price', '>', 10)
            ->where('stock', '>', 30)
            ->get();

        // WHERE price < 30 OR stock = 0
        $conditionOr = DB::table('products')
            ->where('price', '<', 30)
            ->orWhere('stock', 0)
            ->get();

        // WHERE (price > 100 OR name LIKE '%gaming%') AND is_active = true
        $conditionAndOr = DB::table('products')
            ->where(function ($query) {
                $query->where('price', '>', 100)
                      ->orWhere('name', 'LIKE', '%gamimg%');
            })
            ->where('is_active', true)
            ->get();
        
        return [  
            'conditionAnd' => $conditionAnd,
            'conditionOr' => $conditionOr,
            'conditionAndOr' => $conditionAndOr,
        ];
    }

    public function where()
    {
        // WHERE id IN (1, 3, 5)
        $whereIn = DB::table('products')
            ->whereIn('id', [1, 3, 5])
            ->get();
        
        $whereNotIn = DB::table('products')
            ->whereNotIn('id', [2,4,6])
            ->get();

        return [
            'whereIn' => $whereIn,
            'whereNotIn' => $whereNotIn
        ];
    }

    public function whereDate()
    {
        // WHERE created_at = '2024-01-15'
        $products = DB::table('products')
            ->whereDate('created_at', '2024-01-15')
            ->get();
        
        // WHERE created_at > '2024-01-01'
        $recentProducts = DB::table('products')
            ->whereDate('created_at', '>', '2025-01-01')
            ->get();
        
        return [
            'specific_date' => $products,
            'recent' => $recentProducts
        ];
    }

    // Ejercicio: Encontrar productos que:
    // - Tengan precio entre 20 y 200
    // - Estén activos
    // - Tengan stock mayor a 0
    // - Su nombre contenga 'Mouse' o 'wireless'
    // - Ordenados por precio descendente
    public function practiceDB() {
        $products = DB::table('products')
            ->whereBetween('price', [20,200])
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%Mouse%')
                      ->orWhere('name', 'LIKE', '%wireless%');
            })
            ->orderBy('price','desc')
            ->get();

        return $products;
    }
}
