<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client\MSClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DataController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    /**
     * Получить список организаций
     */
    public function getOrganizations(): JsonResponse
    {
        $organizations = Cache::remember('ms_organizations', 600, function () {
            return $this->msClient->get('entity/organization')['rows'] ?? [];
        });

        return response()->json($organizations);
    }

    /**
     * Получить список каналов продаж
     */
    public function getSalesChannels(): JsonResponse
    {
        $salesChannels = Cache::remember('ms_sales_channels', 600, function () {
            return $this->msClient->get('entity/saleschannel')['rows'] ?? [];
        });

        return response()->json($salesChannels);
    }

    /**
     * Получить список проектов
     */
    public function getProjects(): JsonResponse
    {
        $projects = Cache::remember('ms_projects', 600, function () {
            return $this->msClient->get('entity/project')['rows'] ?? [];
        });

        return response()->json($projects);
    }

    /**
     * Получить список товаров
     */
    public function getProducts(): JsonResponse
    {
        $products = Cache::remember('ms_products', 600, function () {
            return $this->msClient->get('entity/product')['rows'] ?? [];
        });

        return response()->json($products);
    }
}

