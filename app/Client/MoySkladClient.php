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


    public function __construct(?string $token = null, string $id)
    {

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


    // метод для выполнения запросов к API
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

    // получить все задачи 
    public function getTasks(): ?array
    {
        return $this->request('GET', 'entity/task');
    }

    // создать новую задачу
    public function createTask(array $taskData): ?array
    {
        return $this->request('POST', 'entity/task', ['json' => $taskData]);
    }

    // удалить задачу по ID
    // public function deleteTask(string $taskId)
    // {
    //     return  $this->request('DELETE', "entity/task/{$taskId}");
    // }
    
    public function deleteTask(string $taskId): bool
    {
        try {
            $response = $this->client->delete("entity/task/{$taskId}");
            if (in_array($response->getStatusCode(), [200, 204])) {
                return true;
            }
            return false;
        } catch (RequestException $e) {
            $errorBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            return false;
        }
    }

    // обновить задачу
    public function updateTask(string $taskId, array $taskData): ?array
    {
        return $this->request('PUT', "entity/task/{$taskId}", ['json' => $taskData]);
    }

    // получить задачу по ID
    public function getTaskById(string $taskId): ?array
    {
        return $this->request('GET', "entity/task/{$taskId}");
    }

    // список юзера
    public function getExecutor(): ?array
    {
        return $this->request('GET', 'entity/employee');
    }
}
