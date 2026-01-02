<?php
namespace App\Shared\Validators;

class ContentValidator {
    public static function validateTitle($title, $maxLength = 255) {
        $title = trim($title);

        if (empty($title)) {
            throw new \Exception('Title cannot be empty.');
        }

        if (strlen($title) > $maxLength) {
            throw new \Exception('Title cannot exceed {$maxLength} characters.');
        }

        return $title;
    }

    public static function validateContent($content) {
        $content = trim($content);

        if (empty($content)) {
            throw new \Exception('Content cannot be empty.');
        }

        return $content;
    }

    public static function sanitizeHtml($content) {
        return htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }
}