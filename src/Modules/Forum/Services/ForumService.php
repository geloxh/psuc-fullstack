<?php
namespace App\Modules\Forum\Services;

use App\Modules\Forum\Repositories\ForumRepository;

class ForumService {
    private $forumRepository;

    public function __construct($forumRepository) {
        $this->forumRepository = $forumRepository;
    }

    public function getCategories() {
        return $this->forumRepository->getCategories();
    }

    public function getForumById($forum_id) {
        return $this->forumRepository->getForumInfo($forum_id);
    }

    public function getForumsByCategory($categoryId) {
        return $this->forumRepository->getForumsByCategory($categoryId);
    }

    public function getForumWithCategory($forum_id) {
        return $this->forumRepository->getForumWithCategory($forum_id);
    }

    public function getTotalTopics($forum_id) {
        return $this->forumRepository->getTotalTopics($forum_id);
    }
}