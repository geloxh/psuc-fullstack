<?php
namespace App\Core\Router;

class Router {
    private $routes = [];
    private $container;

    public function __construct($container = null) {
        $this->container = $container;
    }

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                return $this->callHandler($route['handler']);
            }
        }
        
        http_response_code(404);
        echo "404 Not Found";
    }

    private function matchPath($routePath, $uri, &$params = []) {
        $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $routePattern = '#^' . $routePattern . '$#';

        if (preg_match($routePattern, $uri, $matches)) {
            $params = array_slice($matches, 1);
            return true;
        }
        return false;       
    }

    private function callHandler($handler, $params = []) {
        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$class, $method] = explode('@', $handler);

            if (!class_exists($class)) {
                http_response_code(404);
                echo "Controller not found";
                return;
            }

            // Use container to resolve dependencies
            if ($this->container) {
                $controller = $this->container->resolve($class);
            } else {
                $controller = new $class();
            }

            if (!method_exists($controller, $method)) {
                http_response_code(404);
                echo "Method not found";
                return;
            }

            return $controller->$method(...$params);
        }

        return $handler;
    }
}
