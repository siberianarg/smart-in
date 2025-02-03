<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clients\MoySkladClient;
use App\Models\Task;

class TaskController extends Controller
{
    protected $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function syncTasks()
    {
        $tasks = $this->msClient->getTasks();

        foreach ($tasks as $taskData) {
            Task::updateOrCreate(
                ['ms_uuid' => $taskData['id']],
                ['title' => $taskData['name'], 'status' => $taskData['state']]
            );
        }

        return response()->json(['message' => 'Tasks synced successfully']);
    }

    public function store(Request $request)
    {
        $taskData = [
            'name' => $request->title,
            'description' => $request->description
        ];

        $response = $this->msClient->createTask($taskData);

        if (isset($response['id'])) {
            Task::create([
                'ms_uuid' => $response['id'],
                'title' => $request->title,
                'status' => 'new'
            ]);
        }

        return response()->json(['message' => 'Task created']);
    }
}
