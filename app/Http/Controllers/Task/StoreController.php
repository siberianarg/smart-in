<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Task;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request) //request
    {
        try {
            $data = $request->validated(); // get data
            Task::create($data); // create data

            return response()->json(['message' => 'Task created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating task',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
