<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
     public function index()
    {
        // OPCIÓN 1: Usando DB Facade (SQL directo)
        $users = DB::select('SELECT * FROM users');
        
        // Si no hay usuarios en la BD, usamos datos de ejemplo
        if (empty($users)) {
            $users = [
                (object) [
                    'id' => 1,
                    'name' => 'Juan Pérez',
                    'email' => 'juan.perez@example.com',
                    'role' => 'admin',
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                    'avatar' => 'https://ui-avatars.com/api/?name=Juan+Perez&background=3b82f6&color=fff'
                ],
                (object) [
                    'id' => 2,
                    'name' => 'María García',
                    'email' => 'maria.garcia@example.com',
                    'role' => 'editor',
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                    'avatar' => 'https://ui-avatars.com/api/?name=Maria+Garcia&background=8b5cf6&color=fff'
                ],
                (object) [
                    'id' => 3,
                    'name' => 'Carlos López',
                    'email' => 'carlos.lopez@example.com',
                    'role' => 'user',
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                    'avatar' => 'https://ui-avatars.com/api/?name=Carlos+Lopez&background=10b981&color=fff'
                ],
                (object) [
                    'id' => 4,
                    'name' => 'Ana Martínez',
                    'email' => 'ana.martinez@example.com',
                    'role' => 'user',
                    'status' => 'inactive',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-15 days')),
                    'avatar' => 'https://ui-avatars.com/api/?name=Ana+Martinez&background=ef4444&color=fff'
                ],
            ];
        }
        
        // Retornar vista con los datos
        return view('users.index', [
            'users' => $users
        ]);
    }
}
