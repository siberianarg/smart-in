<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Task;
use App\Client\MoySkladClient;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            // Создаём задачу в МойСклад
            $msClient = new MoySkladClient(
                config('services.moysklad.token'),
                config('services.moysklad.accountId')
            );

            $msTask = $msClient->createTask([
                'description' => $data['description'],
                'done' => $data['is_completed'] ?? false,
            ]);

            dd($msTask);

            // Сохраняем в локальной базе с UUID из МойСклад
            $task = Task::create([
                'description' => $data['description'],
                'is_completed' => $data['is_completed'] ?? false,
                'ms_uuid' => $msTask['id'] ?? null, // Сохраняем ID из МойСклад
            ]);

            return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating task',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
