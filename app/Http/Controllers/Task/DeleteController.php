<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;

class DeleteController extends Controller
{
    public function __invoke(Task $task)
    {
        $task->delete();
        return response([]);
    }
}

