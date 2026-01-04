<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class VehicleController extends BaseController
{
    public function index() :string
    {
        try {
            return View::render("vehicles/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }
    }

    public function show(int $id) :string
    {
        try{
            return View::render("vehicles/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }
    public function listVehicles() :void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $vehicles = $swapiService->fetchAllVehicles($page);
            $this->jsonResponse([
                'success' => true,
                'data' => $vehicles,
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch vehicles'
            ], 500);
        }
    }
    public function getVehicle(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $vehicles = $swapiService->fetchVehicleById($id);
            $this->jsonResponse([
                'success' => true,
                'data' => $vehicles,
            ], 200 );
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch vehicle'
            ], 500);
        }
    }
}