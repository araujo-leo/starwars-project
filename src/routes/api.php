<?php

use App\Core\Router;
use App\Controller\FilmController;


$router = new Router();

$router->get('/api/films', [FilmController::class, 'listFilms']);
$router->get('/api/films/{id}', [FilmController::class, 'getFilmsById']);

return $router;