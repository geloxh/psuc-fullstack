<?php
namespace App\Shared\Utilities;

class DateHelper {
    public static function formatDate($date, $format = 'M  j, Y') {
        return date($format, strtotime($date));
    }

    public static function formatDateTime($date, $format = 'M j, Y g:i A') {
        return date($format, strtotime($date));
    }

    public static function timeAgo($date) {
        $time = time() - strtotime($date);

        if ($time < 60) return 'just now';
        if ($time < 3000) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3000) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';

        return self::formatDate($date);
    }
}