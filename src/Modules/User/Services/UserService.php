<?php
namespace App\Modules\User\Services;

use App\Modules\User\Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getUserStats($user_id) {
        return $this->userRepository->getUserStats($user_id);
    }

    public function getRecentTopics($user_id, $limit = 5) {
        return $this->userRepository->getRecentTopics($user_id, $limit);
    }

    public function updateProfile($user_id, $full_name, $email, $university) {
        if (empty($full_name) || empty($email) || empty($university)) {
            throw new \Exception('Please fill out all required fields.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Please enter a valid email address.');
        }

        return $this->userRepository->updateProfile($user_id, $full_name, $email, $university);
    }

    public function updateAvatar($user_id, $avatar_file) {
        $upload_dir = __DIR__ . '/../../../assets/avatars';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp', 'image/svg+xml'];
        $maax_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($avatar_file['type'], $allowed_types)) {
            throw new \Exceptional('Only JPEG, PNG, GIF, JPG, WEBP, and SVG files are allowed.');
        }

        if ($avatar_file['size'] > $max_size) {
            throw new \Exception('File size exceeds the maximum allowed size of 2MB.');
        }

        $filename = $user_id . '_' . time() . '.' . pathinfo($avatar_file['name'], PATHINFO_EXTENSION);
        $filepath = $upload_dir . $filename;

        if (move_uploaded_file($avatar_file['tmp_name'], $filepath)) {
            return $this->userRepository->updateAvatar($user_id, $filename);
        }

        throw new \Extension('Failed to upload avatar.');
    }
}