<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoreController extends HomeController {

    public function __invoke(Request $request) {
        $employees = $this->msClient->getEmployees();
        if (empty($employees['rows'])) {
            return response()->json(['error' => 'No employees found'], 400);
        }

        $firstEmployee = $employees['rows'][0];
        $isCompleted = filter_var($request->input('is_completed', false), FILTER_VALIDATE_BOOLEAN);

        $taskData = [
            'description' => $request->input('description'),
            'done' => $isCompleted,
            'assignee' => [
                'meta' => $firstEmployee['meta'],
            ],
        ];

        $msTask = $this->msClient->createTask($taskData);

        if ($msTask) {
            $task = Task::create([
                'ms_uuid' => $msTask['id'],
                'description' => $taskData['description'],
                'is_completed' => (int) $isCompleted,
                'created_at' => Carbon::parse($msTask['created'] ?? now()),
            ]);
            return response()->json($task, 201);
        }

        return response()->json(['error' => 'Failed to create task'], 500);
    }
}
