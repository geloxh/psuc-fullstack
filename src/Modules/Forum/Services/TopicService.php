<?php
namespace App\Modules\Forum\Services;

use App\Modules\Forum\Repositories\TopicRepository;

class TopicService {
    private $topicRepository;

    public function __construct(TopicRepository $topicRepository) {
        $this->topicRepository = $topicRepository;
    }

    public function getTopics($forum_id, $limit = 20, $offset = 0) {
        return $this->topicRepository->getTopics($forum_id, $limit, $offset);
    }

    public function getTopicById($topic_id) {
        $topic = $this->topicRepository->getTopicById($topic_id);
        if ($topic) {
            $this->topicRepository->incrementViews($topic_id);
        }
        return $topic;
    }

    public function getTopicsWithDetails($forum_id, $limit = 20, $offset = 0) {
        return $this->topicRepository->getTopicsWithDetails($forum_id, $limit, $offset);
    }

    public function createTopic($forum_id, $user_id, $title, $content) {
        $title = trim($title);
        $content = trim($content);

        if (empty($title) || empty($content)) {
            throw new \Exception('Title and content are required.');
        }

        return $this->topicRepository->create($forum_id, $user_id, $title, $content);
    }

    public function updateTopic($topicId, $title, $content) {
        return $this->topicRepository->update($topic_id, $title, $content);
    }

    public function deleteTopic($topic_id) {
        return $this->topicRepository->delete($topic_id);
    }
}