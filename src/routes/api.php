<?php

use App\Core\Router;
use App\Controller\WebController;
use App\Controller\ApiController;

$router = new Router();

$router->get('/api/films', [ApiController::class, 'listFilms']);
$router->get('/api/film-details', [ApiController::class, 'getFilmDetails']);

return $router;