<?php
use App\Core\Router;
use App\Controller\FilmController;
$router->get('/', [FilmController::class, 'index']);
