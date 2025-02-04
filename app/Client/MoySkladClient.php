<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\MainSettings;

class MoySkladClient
{
    private Client $client;
    private string $token;
    private string $id;

    public function __construct(?string $token = null, string $id)
    {
        $this->id = $id;
        
        if (is_null($token)) {
            $settings = MainSettings::find($id);
            if (!$settings || empty($settings->ms_token)) {
                throw new \RuntimeException("Token for MoySklad is missing.");
            }
            $this->token = $settings->ms_token;
        } else {
            $this->token = $token;
        }

        $this->client = new Client([
            'base_uri' => 'https://api.moysklad.ru/api/remap/1.2/',
            'headers'  => [
                'Authorization'   => 'Bearer ' . $this->token,
                'Accept-Encoding' => 'gzip',
                'Content-Type'    => 'application/json',
            ],
        ]);
    }

    /**
     * Универсальный метод для выполнения запросов к API
     */
    private function request(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $errorBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error("MoySklad API Error ({$method} {$url}): " . $errorBody);
            return null;
        }
    }

    /**
     * Получить все задачи
     */
    public function getTasks(): ?array
    {
        return $this->request('GET', 'entity/task');
    }

    /**
     * Создать новую задачу
     */
    public function createTask(array $taskData): ?array
    {
        return $this->request('POST', 'entity/task', ['json' => $taskData]);
    }

    /**
     * Удалить задачу по ID
     */
    public function deleteTask(string $taskId): bool
    {
        return (bool) $this->request('DELETE', "entity/task/{$taskId}");
    }

    /**
     * Обновить задачу
     */
    public function updateTask(string $taskId, array $taskData): ?array
    {
        return $this->request('PUT', "entity/task/{$taskId}", ['json' => $taskData]);
    }

    /**
     * Получить задачу по ID
     */
    public function getTaskById(string $taskId): ?array
    {
        return $this->request('GET', "entity/task/{$taskId}");
    }

    /**
     * Получить список сотрудников
     */
    public function getEmployees(): ?array
    {
        return $this->request('GET', 'entity/employee');
    }
}
