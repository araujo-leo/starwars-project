<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class StarshipController
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
            header('Content-Type: application/json');

            Log::save('INFO', "/starships?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $starships
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/starships?page=$page");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
    public function getStarship($id) :void
    {
        try {
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchStarshipById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/starships/$id");
            echo json_encode([
                'success' => true,
                'data' => $starships
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/starships/$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
}