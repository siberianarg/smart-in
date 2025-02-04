<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends HomeController {

    public function __invoke(Request $request)
    {
        $tasks = Task::all();
        $msTasks = $this->msClient->getTasks();

        $msTasksCollection = collect($msTasks['rows'])->mapWithKeys(function ($task) {
            return [$task['id'] => [
                'id' => $task['id'],
                'description' => $task['description'] ?? 'Описание отсутствует',
                'is_completed' => (bool) ($task['done'] ?? false),
                'created_at' => Carbon::parse($task['created'] ?? now()),
                'updated_at' => Carbon::parse($task['updated'] ?? now()),
            ]];
        });

        foreach ($msTasksCollection as $taskId => $taskData) {
            Task::updateOrCreate(
                ['ms_uuid' => $taskId],
                [
                    'description' => $taskData['description'],
                    'is_completed' => $taskData['is_completed'],
                    'created_at' => $taskData['created_at'],
                    'updated_at' => $taskData['updated_at'],
                ]
            );
        }

        $updatedTasks = Task::all();
        return response()->json(['data' => $updatedTasks]);
    }
}
