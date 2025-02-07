<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\MainSettings;

class MoySkladProductClient
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

        // Проверим токен перед выполнением запросов
        Log::info("MoySklad API Token: " . $this->token);

        $this->client = new Client([
            'base_uri' => 'https://api.moysklad.ru/api/remap/1.2/',
            'headers'  => [
                'Authorization'   => 'Bearer ' . $this->token,
                'Accept-Encoding' => 'gzip',
                'Content-Type'    => 'application/json',
            ],
        ]);
    }


    // Общий метод для выполнения запросов
    private function request(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);
            $body = json_decode($response->getBody()->getContents(), true);

            // Логируем ответ для проверки
            Log::info("MoySklad API Response:", $body);

            return $body;
        } catch (RequestException $e) {
            $errorBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error("MoySklad API Error ({$method} {$url}): " . $errorBody);
            return null;
        }
    }


    // Получение списка товаров
    public function getProducts(): ?array
    {
        return $this->request('GET', 'entity/product');
    }

    // Создание нового товара
    public function createProduct(array $productData): ?array
    {
        return $this->request('POST', 'entity/product', ['json' => $productData]);
    }

    // Обновление товара по ID
    public function updateProduct(string $productId, array $productData): ?array
    {
        return $this->request('PUT', "entity/product/{$productId}", ['json' => $productData]);
    }

    // Удаление товара по ID
    public function deleteProduct(string $productId)
    {
        return $this->request('DELETE', "entity/product/{$productId}");
    }

    // Получение товара по ID
    public function getProductById(string $productId): ?array
    {
        return $this->request('GET', "entity/product/{$productId}");
    }
}
