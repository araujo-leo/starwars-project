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
            echo $controller->$action();
        }

        foreach ($this->routes[$method] as $routePath => $callback) {
            if (strpos($routePath, '{') === false) {
                continue;
            }

            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controllerClass, $action] = $callback;
                $controller = new $controllerClass();

                echo $controller->$action(...$matches);
                return;
            }
        }

        echo json_encode(['error' => 'Endpoint not found'], 404);
    }
}