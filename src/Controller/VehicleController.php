<?php

namespace App\Controller;

use App\Service\SwapiService;

class VehicleController
{
    public function listVehicles() {
        try {
            $swapiService = new SwapiService();
            $vehicles = $swapiService->fetchAllVehicles();
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $vehicles
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
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
            echo json_encode([
                'success' => true,
                'data' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch vehicles'
            ], 500);
        }
    }
}