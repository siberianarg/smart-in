<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function __invoke() {
        $persons = [
            [
                'id' => 1,
                'name' => 'Zhan',
                'age' => '20',
                'job' => 'developer',

            ],
            [
                'id' => 2,
                'name' => 'Olga',
                'age' => '25',
                'job' => 'QA',

            ],
            [
                'id' => 3,
                'name' => 'Ilya',
                'age' => '24',
                'job' => 'HR',

            ],
            ];

        return $persons;
    }
}

