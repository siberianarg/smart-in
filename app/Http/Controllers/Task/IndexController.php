<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Client\MoySkladClient;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $localTasks = Task::all();

        try {
            // Получаем задачи из МойСклад
            $msClient = new MoySkladClient(
                config('services.moysklad.token'),
                config('services.moysklad.accountId')
            );
            $msTasks = collect($msClient->getTasks()['rows'] ?? []);
        } catch (\Exception $e) {
            $msTasks = collect(); // В случае ошибки просто игнорируем
        }

        // Объединяем задачи
        $allTasks = $localTasks->merge($msTasks);

        return TaskResource::collection($allTasks);
    }
}
