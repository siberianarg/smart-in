<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

class DeleteController extends Controller {

    private MoySkladClient $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function __invoke($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $ms_uuid = $task->ms_uuid;
        $deleted = $this->msClient->deleteTask($ms_uuid);

        if ($deleted) {
            $task->delete();
            return response()->json(null, 204);
        }

        return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
    }
}
