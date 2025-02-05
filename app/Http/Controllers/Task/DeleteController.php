<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    private MoySkladClient $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function __invoke($id)
    {
        // Ищем задачу в локальной БД
        $task = Task::find($id);

        if (!$task) {
            Log::warning("Task not found in local DB: ID $id");
            return response()->json(['error' => 'Task not found'], 404);
        }

        $ms_uuid = $task->ms_uuid;

        // Удаляем задачу из МойСклад
        $deleted = $this->msClient->deleteTask($ms_uuid);

        if (!$deleted) {
            Log::error("Failed to delete task in MoySklad: MS_UUID $ms_uuid");
            return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
        }

        // Удаляем задачу из локальной БД
        $task->delete();

        Log::info("Task successfully deleted: Local ID $id, MS_UUID $ms_uuid");

        return response()->json(null, 204);
    }
}
