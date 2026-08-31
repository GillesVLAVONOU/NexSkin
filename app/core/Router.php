<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $middleware = [];

    public function get(string $path, array $action, array $middleware = []): self
    {
        $this->addRoute('GET', $path, $action, $middleware);
        return $this;
    }

    public function post(string $path, array $action, array $middleware = []): self
    {
        $this->addRoute('POST', $path, $action, $middleware);
        return $this;
    }

    private function addRoute(string $method, string $path, array $action, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Use ?url= param from .htaccess, or fallback to REQUEST_URI
        if (isset($_GET['url'])) {
            $uri = '/' . ltrim($_GET['url'], '/');
        } else {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            // Strip base path (e.g., /public/) to match routes
            $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
            if ($scriptDir !== '/' && $scriptDir !== '\\') {
                $uri = substr($uri, strlen($scriptDir));
            }
        }

        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    if (!$middleware->handle()) {
                        return;
                    }
                }

                [$controllerClass, $action] = $route['action'];
                $controller = new $controllerClass();
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        http_response_code(404);
        require ROOT_PATH . '/app/views/errors/404.php';
    }

    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
