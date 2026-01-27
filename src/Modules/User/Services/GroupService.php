<?php
namespace App\Modules\User\Services;

use App\Modules\User\Repositories\GroupRepository;

class GroupService {
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function getAllGroups() {
        return $this->groupRepository->getAll();
    }

    public function getGroupById($id) {
        return $this->groupRepository->findById($id);
    }
}