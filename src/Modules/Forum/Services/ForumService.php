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

    public function getForumsByCategory($categoryId) {
        return $this->forumRepository->getForumsByCategory($categoryId);
    }
}