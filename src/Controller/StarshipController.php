<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class StarshipController extends BaseController
{
    public function index() :string
    {
        try {
            return View::render("starships/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }

    }

    public function show(int $id) :string
    {
        try{
            return View::render("starships/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }
    public function listStarships() :void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchAllStarships($page);
            $this->jsonResponse([
                'success' => true,
                'data' => $starships,
            ],200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
    public function getStarship(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchStarshipById($id);
            $this->jsonResponse([
               'success' => true,
                'data' => $starships,
            ], 200 );
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch starship'
            ], 500);
        }
    }
}