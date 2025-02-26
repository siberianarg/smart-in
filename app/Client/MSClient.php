<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class MSClient
{
    private Client $client;
    private string $token;
    private string $accountId;

    public function __construct(?string $token = null, string $accountId)
    {
        $this->token = $token;
        $this->accountId = $accountId;

        $this->client = new Client([
            'base_uri' => 'https://api.moysklad.ru/api/remap/1.2/',
            'headers'  => [
                'Authorization'   => 'Bearer ' . $this->token,
                'Accept-Encoding' => 'gzip',
                'Content-Type'    => 'application/json',
            ],
        ]);
    }

    public function get(string $url): ?array
    {
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }

    public function create(array $data, string $url): ?array
    {
        try {
            $response = $this->client->post($url, ['json' => $data]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function update(string $url, array $data): ?array
    {
        try {
            $response = $this->client->put($url, ['json' => $data]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function delete(string $url): bool
    {
        try {
            $response = $this->client->delete($url);
            return in_array($response->getStatusCode(), [200, 204]);
        } catch (RequestException $e) {
            return $this->handleError($e, false);
        }
    }

    public function getRetailPriceTypeMeta() {
        try {
            $response = $this->client->get('context/companysettings/pricetype');
            $priceTypes = json_decode($response->getBody(), true);
            return !empty($priceTypes) && isset($priceTypes[0]['meta']) ? $priceTypes[0]['meta'] : null;
        } catch (ClientException $e) {
            return null;
        }
    }

    private function handleError(RequestException $e, $returnValue = null)
    {
        $errorBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
        dd('Ошибка запроса к API МойСклад:', $errorBody);
        return $returnValue;
    }

        // public function getRetailCustomerId(): ?string
    // {
    //     return Cache::remember('retail_customer_id', 600, function () {
    //         $response = $this->get('entity/counterparty', ['filter' => 'name=Розничный покупатель']);
    //         if (!isset($response['rows']) || empty($response['rows'])) {
    //             dd('Розничный покупатель не найден');
    //         }
    //         return $response['rows'][0]['id'] ?? null;
    //     });
    // }
}
