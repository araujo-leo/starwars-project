<?php

namespace App\Controller;

use App\Model\Log;
use App\Service\SwapiService;

class SpeciesController
{
    public function listSpecies() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $species = $swapiService->fetchAllSpecies();
            header('Content-Type: application/json');

            Log::save('INFO', "/species?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $species
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/species?page=$page");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
    public function getSpecies($id)
    {
        try {
            $swapiService = new SwapiService();
            $species = $swapiService->fetchSpecieById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/species?id=$id");
            echo json_encode([
                'success' => true,
                'data' => $species
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/species?id=$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
}