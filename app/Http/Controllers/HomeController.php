<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client\MSClient;

class HomeController extends Controller
{
    protected $msClient;

    public function __construct(MSClient $msClient) {
        $this->msClient = $msClient;
    }
    
    public function redirectToTaskPage(){
        return to_route(
            'home', [
                'is_vue_pade' => 'tasks',
            ]
        );
    }

    public function index()
    {
        return view('app');
    }
}