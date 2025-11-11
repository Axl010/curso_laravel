<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::select('select * from users where email = ?', ['test@example.com']);
        
        foreach ($users as $user) {
            echo $user->all();
        }
    }

    public function store()
    {
        $users = DB::insert('insert into users (id,name) values ( ?, ?)', [1, 'Marco']);
    }
}
