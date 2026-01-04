<?php
namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;
use App\Config\Database;
use Exception;

class FilmController extends BaseController
{
    public function index() :string
    {
        return View::render("films/index");
    }

    public function show(int $id) :string
    {
        return View::render("films/show", ['id' => $id]);
    }
    public function listFilms() :void
    {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchAllFilms();
            $this->jsonResponse([
                'success' => true,
                'data' => $films
            ], 200);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'error' => true,
                'message' => 'Failed to fetch films'
            ], 500);
        }
    }

    public function getFilmsById(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchFilmById($id);
            $this->jsonResponse([
                'success' => true,
                'data' => $films
            ], 200);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'error' => true,
                'message' => 'Failed to fetch film'
            ], 500);
        }
    }
}