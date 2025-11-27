<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLowStock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $raw = $request->route('quote', 5);

        if(!is_numeric($raw) || (int)$raw < 0) {
            return response()->json([
                'success' => false,
                'message' => 'El parámetro "quote" debe ser un número entero >= 0'
            ], 400);
        }

        $request->merge(['min_stock' => (int) $raw]);
        
        return $next($request);
    }
}