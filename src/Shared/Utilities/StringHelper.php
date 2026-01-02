<?php
namespace App\Shared\Utilities;

class StringHelper {
    public static function truncate($text, $length = 100, $suffix = '...') {
        if(strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . $suffix;
    }

    public static function slug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }

    public static function sanitizeFilename($filename) {
        return preg_replace('/[^A-Za-z0-9._-]/', '', $filename);
    }

    public static function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
    }
}