<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class PlanetController extends BaseController
{
    public function index() :string
    {
        try {
            return View::render("planets/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }

    }

    public function show(int $id) :string
    {
        try{
            return View::render("planets/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }

    public function listPlanets()  :void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $planets = $swapiService->fetchAllPlanets($page);
            $this->jsonResponse([
                'success' => true,
                'data' => $planets,
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'error' => true,
                'message' => 'Failed to fetch planets'
            ], 500);
        }
    }
    public function getPlanet(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $planets = $swapiService->fetchPlanetById($id);
            header('Content-Type: application/json');

            $this->jsonResponse([
                'success' => true,
                'data' => $planets,
            ], 200 );
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'error' => true,
                'message' => 'Failed to fetch planet'
            ], 500);
        }
    }
}