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

    //tasks 
    public function getTasks(string $url): ?array
    {
        return $this->request('GET', $url);
    }

    public function createTask(array $taskData, string $url): ?array
    {
        return $this->request('POST', $url, ['json' => $taskData]);
    }

    public function deleteTask(string $url)
    {
        return  $this->request('DELETE', $url);
    }

    public function updateTask(string $url, array $taskData): ?array
    {
        return $this->request('PUT', $url, ['json' => $taskData]);
    }

    public function getTaskById(string $url): ?array
    {
        return $this->request('GET', $url);
    }

    // список юзера
    public function getExecutor(string $url): ?array
    {
        return $this->request('GET', $url); 
    }

    
    //product
    public function getProducts(string $url): ?array
    {
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true)['rows'];
    }

    public function createProduct(array $productData, string $url): ?array
    {
        return $this->request('POST', $url, ['json' => $productData]);
    }

    public function updateProduct(string $url, array $productData): ?array
    {
        return $this->request('PUT', $url, ['json' => $productData]);
    }

    public function deleteProduct(string $url)
    {
        return $this->request('DELETE', $url);
    }

    public function getProductById(string $url): ?array
    {
        return $this->request('GET', $url);
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
