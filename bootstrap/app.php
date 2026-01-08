<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Compose Autoloader
require_once __DIR__ . '/../src/Core/Container/ServiceContainer.php';
require_once __DIR__ . '/../src/Core/Router/Router.php';
require_once __DIR__ . '/../src/Core/Database/Connection.php';

use App\Core\Container\ServiceContainer;
use App\Core\Router\Router;
use App\Core\Database\Connection;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Forum\Services\ForumService;
use App\Modules\Forum\Services\TopicService;
use App\Modules\User\Services\UserService;
use App\Modules\Research\Services\ResearchService;

$container = new ServiceContainer();

$container->bind('database', function() {
    return Connection::getInstance();
});

$container->bind(AuthService::class, function($container) {
    return new AuthService($container->get('database')->getConnection());
});

$container->bind(ForumService::class, function($container) {
    return new ForumService($container->get('database')->getConnection());
});

$container->bind(TopicService::class, function($container) {
    return new TopicService($container->get('database')->getConnection());
});

$container->bind(UserService::class, function($container) {
    return new UserService($container->get('database')->getConnection());
});

$container->bind(ResearchService::class, function($container) {
    return new ResearchService($container->get('database')->getConnection());
});

$router = new Router($container);

// Register routes
require_once __DIR__ . '/../routes/web.php';

return $router;