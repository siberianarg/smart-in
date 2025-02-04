<?php

namespace App\Client;

use GuzzleHttp\Client;
use App\Models\MainSettings;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class MoySkladClient
{
    private Client $client;
    private string $token;
    private string $id;

    public function __construct($token, string $id) //пописать конструктор
    {
        // $settings = MainSettings::firstOrFail($id); // findOrFail
        // $this->token = $settings->ms_token;

        $this->token = $token;
        $this->id = $id;

        $this->client = new Client([
            'base_uri' => 'https://api.moysklad.ru/api/remap/1.2/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type'  => 'gzip',
            ]
        ]);
    }

    public function getTasks()
    {
        try {
            $response = $this->client->get('entity/task');
            return json_decode($response->getBody(), true); //try catch!
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $errorBody = $response->getBody()->getContents();
            Log::error('MoySklad API Error: ' . $errorBody);
            throw $e;
        }
    }

    public function createTask($data)
    {
        $response = $this->client->post('entity/task', [
            'json' => $data
        ]);
        return json_decode($response->getBody(), true);
    }

    public function deleteTask($taskId)
    {
        try {
            $this->client->delete("entity/task/{$taskId}");
            return true;
        } catch (ClientException $e) {
            Log::error('MoySklad API Error (deleteTask): ' . $e->getMessage());
            return false;
        }
    }
    
    public function updateTask($taskId, $taskData)

    {
        try {
            $response = $this->client->put("entity/task/{$taskId}", [
                'json' => $taskData,
            ]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('MoySklad API Error (updateTask): ' . $e->getMessage());
            return null;
        }
    }

    public function getTaskById($taskId)
    {
        try {
            $response = $this->client->get("entity/task/{$taskId}");
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('MoySklad API Error (getTaskById): ' . $e->getMessage());
            return null;
        }
    }

    public function getEmployees()
    {
        try {
            $response = $this->client->get('entity/employee');
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('MoySklad API Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
