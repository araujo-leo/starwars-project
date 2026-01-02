<?php
namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;
use App\Config\Database;
use Exception;

class FilmController {
    public function index(){
        return View::render("films/index");
    }

    public function show($id)
    {
        return View::render("films/show", ['id' => $id]);
    }
    public function listFilms() {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchAllFilms();
            header('Content-Type: application/json');

            Log::save('INFO', "/films");
            echo json_encode([
                'succes' => true,
                'data' => $films
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/films");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch films'
            ], 500);
        }
    }

    public function getFilmsById($id) {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchFilmById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/films/$id");
            echo json_encode([
                'succes' => true,
                'data' => $films
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/films/$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch films'
            ], 500);
        }
    }
}