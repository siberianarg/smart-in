<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }
    
    //список организаций
    public function getOrganizations(): JsonResponse
    {
        try {
            $organizations = $this->msClient->get('entity/organization')['rows'] ?? [];
            return response()->json($organizations);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка получения организаций: ' . $e->getMessage()], 500);
        }
    }

    //список каналов продаж
    public function getSalesChannels(): JsonResponse
    {
        try {
            $salesChannels = $this->msClient->get('entity/saleschannel')['rows'] ?? [];
            return response()->json($salesChannels);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка получения каналов продаж: ' . $e->getMessage()], 500);
        }
    }

    //список к проектов
    public function getProjects(): JsonResponse
    {
        try {
            $projects = $this->msClient->get('entity/project')['rows'] ?? [];
            return response()->json($projects);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка получения проектов: ' . $e->getMessage()], 500);
        }
    }

    //список контрагентов
    public function getCounterparties(): JsonResponse
    {
        try {
            $counterparties = $this->msClient->get('entity/counterparty')['rows'] ?? [];
            return response()->json($counterparties);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка получения контрагентов: ' . $e->getMessage()], 500);
        }
    }
}
