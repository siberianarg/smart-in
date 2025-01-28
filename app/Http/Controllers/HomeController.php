<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function i(){
        return to_route(
            'home', [
                'is_vue_pade' => 'task',
            ]
        );
    }

    public function index()
    {
        return view('app');
    }
}
