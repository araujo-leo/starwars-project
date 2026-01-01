<?php

use App\Core\Router;
use App\Controller\FilmController;


$router = new Router();

$router->get('/api/films', [FilmController::class, 'listFilms']);
$router->get('/api/film-details', [FilmController::class, 'getFilmDetails']);

return $router;