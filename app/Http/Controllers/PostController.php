<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return 'Lista de todos los posts';
    }

    public function show($id)
    {
        return 'Mostrando post ID: ' . $id;
    }
}
