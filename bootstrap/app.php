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
    $forumRepository = new \App\Modules\Forum\Repositories\ForumRepository($container->get('database')->getConnection());
    return new ForumService($forumRepository);
});

$container->bind(TopicService::class, function($container) {
    $topicRepository = new \App\Modules\Forum\Repositories\TopicRepository($container->get('database')->getConnection());
    return new TopicService($topicRepository);
});

$container->bind(\App\Modules\Events\Repositories\EventRepository::class, function($container) {
    return new \App\Modules\Events\Repositories\EventRepository($container->get('database')->getConnection());
});

$container->bind(\App\Modules\Events\Services\CalendarService::class, function($container) {
    return new \App\Modules\Events\Services\CalendarService($container->resolve(\App\Modules\Events\Repositories\EventRepository::class));
});

$container->bind(\App\Modules\Documents\Repositories\DocumentRepository::class, function($container) {
    return new \App\Modules\Documents\Repositories\DocumentRepository($container->get('database')->getConnection());
});

$container->bind(\App\Modules\Documents\Services\DocumentService::class, function($container) {
    return new \App\Modules\Documents\Services\DocumentService($container->resolve(\App\Modules\Documents\Repositories\DocumentRepository::class));
});

$container->bind(\App\Modules\Jobs\Repositories\JobRepository::class, function($container) {
    return new \App\Modules\Jobs\Repositories\JobRepository($container->get('database')->getConnection());
});

$container->bind(\App\Modules\Jobs\Services\JobService::class, function($container) {
    return new \App\Modules\Jobs\Services\JobService($container->resolve(\App\Modules\Jobs\Repositories\JobRepository::class));
});

$container->bind(\App\Modules\User\Repositories\GroupRepository::class, function($container) {
    return new \App\Modules\User\Repositories\GroupRepository($container->get('database')->getConnection());
});

$container->bind(\App\Modules\User\Services\GroupService::class, function($container) {
    return new \App\Modules\User\Services\GroupService($container->resolve(\App\Modules\User\Repositories\GroupRepository::class));
});

$container->bind(UserService::class, function($container) {
    return new UserService($container->get('database')->getConnection());
});

$container->bind(ResearchService::class, function($container) {
    return new ResearchService($container->get('database')->getConnection());
});

$container->bind(\App\Shared\Services\SearchService::class, function($container) {
    return new \App\Shared\Services\SearchService($container->get('database')->getConnection());
});

$router = new Router($container);

// Register routes
require_once __DIR__ . '/../routes/web.php';

return $router;