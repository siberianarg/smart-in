<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use GuzzleHttp\Exception\RequestException;
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
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $ms_uuid = $task->ms_uuid;

        // удаляем из МойСклад
        $deleted = $this->msClient->deleteTask($ms_uuid);

        if (!$deleted) {
            return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
