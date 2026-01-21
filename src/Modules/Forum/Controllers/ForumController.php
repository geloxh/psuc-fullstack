<?php
namespace App\Modules\Forum\Controllers;

use App\Modules\Forum\Services\ForumService;
use App\Modules\Forum\Services\TopicService;

class ForumController {
    private $forumService;
    private $topicService;

    public function __construct(ForumService $forumService, TopicService $topicService) {
        $this->forumService = $forumService;
        $this->topicService = $topicService;
    }

    
    public function index() {
        $categories = $this->forumService->getCategories();
        include __DIR__ . '/../Views/forum-list.php';
    }

    public function show($forum_id) {
        $forum_info = $this->forumService->getForumById($forum_id);
        if (!$forum_info) {
            header('Location: index.php');
            exit;
        }

        $page = $_GET['page'] ?? 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $topics = $this->topicService->getTopics($forum_id, $limit, $offset);

        include __DIR__ . '/../Views/topic_list.php';
    }
}