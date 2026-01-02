<?php

namespace App\Controller;

use App\Model\Log;
use App\Service\SwapiService;

class VehicleController
{
    public function listVehicles() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $vehicles = $swapiService->fetchAllVehicles();
            header('Content-Type: application/json');

            Log::save('INFO', "/vehicles?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/vehicles?page=$page");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch vehicles'
            ], 500);
        }
    }
    public function getVehicle($id)
    {
        try {
            $swapiService = new SwapiService();
            $vehicles = $swapiService->fetchVehicleById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/vehicles/$id");
            echo json_encode([
                'success' => true,
                'data' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/vehicles/$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch vehicles'
            ], 500);
        }
    }
}