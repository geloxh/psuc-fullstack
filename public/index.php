<?php
    session_start();

    $router = require_once __DIR__ . '/../bootstrap/app.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Remove the base path to get the clean route
    $basePath = '/psuc-fullstack/public';
    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    } elseif (strpos($uri, '/psuc-fullstack') === 0) {
        $uri = substr($uri, strlen('/psuc-fullstack'));
    }

    if (empty($uri)) {
        $uri = '/';
    }
    
    $router->dispatch($method, $uri);

?>