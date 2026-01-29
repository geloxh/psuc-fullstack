<?php
    session_start();

    $router = require_once __DIR__ . '/../bootstrap/app.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
    if ($basePath && strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    if (empty($uri)) {
        $uri = '/';
    }
    
    $router->dispatch($method, $uri);

?>