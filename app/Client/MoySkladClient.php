<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\MainSettings;
use GuzzleHttp\Exception\ClientException;

class MoySkladClient
{
    private Client $client;
    private string $token;
    private string $accountId;


    public function __construct(?string $token = null, string $accountId)
    {
        $this->token = $token;
        $this->accountId = $accountId;
        // dd($token);

        $this->client = new Client([
            'base_uri' => 'https://api.moysklad.ru/api/remap/1.2/',
            'headers'  => [
                'Authorization'   => 'Bearer ' . $this->token,
                'Accept-Encoding' => 'gzip',
                'Content-Type'    => 'application/json',
            ],
        ]);
        // dd($this->client);
    }

    // метод для выполнения запросов к API
    private function request(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();

            if ($method === 'DELETE') {
                return in_array($statusCode, [200, 204]);
            }
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $errorBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            dd('Ошибка авторизации:', $errorBody, $this->client);  // Проверим ошибку от API
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
    public function deleteTask(string $taskId)
    {
        return  $this->request('DELETE', "entity/task/{$taskId}");
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
    public function getExecutor($url): ?array
    {
        return $this->request('GET', $url); 
    }

    
    //product
    public function getProducts($url): ?array
    {
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true)['rows'];
    }

    // Создание нового продукта
    public function createProduct(array $productData, string $url): ?array
    {
        return $this->request('POST', $url, ['json' => $productData]);
    }

    // Обновление продукта
    public function updateProduct(string $productId, array $productData): ?array
    {
        return $this->request('PUT', "entity/product/{$productId}", ['json' => $productData]);
    }

    // Удаление продукта
    public function deleteProduct(string $productId)
    {
        return $this->request('DELETE', "entity/product/{$productId}");
    }

    // Получение продукта по ID
    public function getProductById(string $productId): ?array
    {
        return $this->request('GET', "entity/product/{$productId}");
    }

    public function getRetailPriceTypeMeta()
    {
        try {
            $response = $this->client->get('context/companysettings/pricetype');
            $priceTypes = json_decode($response->getBody(), true);

            if (!empty($priceTypes) && isset($priceTypes[0]['meta'])) {
                return $priceTypes[0]['meta'];
            }
            return null;
        } catch (ClientException $e) {
            return null;
        }
    }
}
