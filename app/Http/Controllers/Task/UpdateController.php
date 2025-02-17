<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller {

    private MoySkladClient $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function __invoke(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            Log::error("Ошибка: Задача с id {$id} не найдена в локальной базе.");
            return response()->json(['error' => 'Task not found'], 404);
        }

        $ms_uuid = $task->ms_uuid;
        Log::info("Редактирование задачи: ID = {$id}, MS_UUID = {$ms_uuid}");

        if (!$ms_uuid) {
            return response()->json(['error' => 'Task does not have a linked MoySklad ID'], 400);
        }

        $url = "entity/task/{$ms_uuid}";

        $msTask = $this->msClient->get($url);

        if (!$msTask) {
            Log::error("Ошибка: Задача с ms_uuid {$ms_uuid} не найдена в МойСклад.");
            return response()->json(['error' => 'Task not found in MoySklad'], 404);
        }

        $newDescription = $request->input('description', $task->description);
        $newIsCompleted = filter_var($request->input('is_completed', $task->is_completed), FILTER_VALIDATE_BOOLEAN);

        $taskData = [
            'description' => $newDescription,
            'done' => $newIsCompleted,
        ];

        $updatedTask = $this->msClient->update($url, $taskData);

        if ($updatedTask) {
            $task->description = $newDescription;
            $task->is_completed = $newIsCompleted;
            $task->updated_at = Carbon::parse($updatedTask['updated'] ?? now());
            $task->save();
            Log::info("Задача успешно обновлена: ID = {$id}, MS_UUID = {$ms_uuid}");
        } else {
            Log::error("Ошибка обновления задачи в МойСклад: MS_UUID = {$ms_uuid}");
        }

        return response()->json($task);
    }
}
