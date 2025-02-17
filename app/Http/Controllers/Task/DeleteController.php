<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MSClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
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

        $url = "entity/task/{$ms_uuid}";
        $deleted = $this->msClient->delete($url);

        if (!$deleted) {
            return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
