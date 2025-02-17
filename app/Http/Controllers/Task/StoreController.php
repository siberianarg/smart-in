<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MSClient;
use App\Http\Requests\Task\StoreRequest;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class StoreController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function __invoke(StoreRequest $request): JsonResponse
    {
        $executors = $this->msClient->get('entity/employee');
        $rows = $executors['rows'] ?? [];

        if (empty($rows)) {
            return response()->json(['error' => 'No executors found'], 400);
        }

        $firstEmployee = reset($rows); // безопасный способ получить первый элемент

        $taskData = [
            'description' => $request->validated()['description'],
            'done'        => $request->validated()['is_completed'] ?? false,
            'assignee'    => ['meta' => $firstEmployee['meta']],
        ];

        $msTask = $this->msClient->create($taskData, 'entity/task');

        if (!$msTask) {
            return response()->json(['error' => 'Failed to create task'], 500);
        }

        $task = Task::create([
            'ms_uuid'      => $msTask['id'],
            'description'  => $taskData['description'],
            'is_completed' => (int) $taskData['done'],
            'created_at'   => Carbon::parse($msTask['created'] ?? now()),
        ]);

        return response()->json($task, 201);
    }
}
