<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        if (isset($this->routes[$method][$uri])) {
            [$controllerClass, $action] = $this->routes[$method][$uri];

            $controller = new $controllerClass();
            $controller->$action();
        } else {
            http_response_code(404);
            echo "Página não encontrada (404)";
        }
    }
}