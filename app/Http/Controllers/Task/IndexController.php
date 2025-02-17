<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Client\MoySkladClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class IndexController extends Controller
{
    private MoySkladClient $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function __invoke(Request $request): JsonResponse
    {   
        $msTasks = $this->msClient->getTasks("entity/task");
        $rows = $msTasks['rows'] ?? [];

        if (empty($rows)) {
            return response()->json(['error' => 'No tasks found in MoySklad'], 400);
        }

        // Получаем список `ms_uuid` из МойСклад
        $msTaskIds = collect($rows)->pluck('id')->toArray();

        // Удаляем из локальной БД задачи, которые есть в MySQL, но нет в МойСклад
        Task::whereNotIn('ms_uuid', $msTaskIds)->delete();

        // Преобразуем API-ответ в коллекцию Laravel
        $msTasksCollection = collect($rows)->mapWithKeys(fn($task) => [
            $task['id'] => [
                'id'           => $task['id'],
                'description'  => $task['description'] ?? 'description is not exist',
                'is_completed' => (bool) ($task['done'] ?? false),
                'created_at'   => Carbon::parse($task['created'] ?? now()),
                'updated_at'   => Carbon::parse($task['updated'] ?? now()),
            ]
        ]);

        // Обновляем или создаём записи в БД
        foreach ($msTasksCollection as $taskId => $taskData) {
            Task::updateOrCreate(
                ['ms_uuid' => $taskId],
                [
                    'description'  => $taskData['description'],
                    'is_completed' => $taskData['is_completed'],
                    'created_at'   => $taskData['created_at'],
                    'updated_at'   => $taskData['updated_at'],
                ]
            );
        }

        // Возвращаем обновлённый список задач
        return response()->json(['data' => Task::all()]);
    }
}
