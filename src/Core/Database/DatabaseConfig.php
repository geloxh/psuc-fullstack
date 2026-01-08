<?php
namespace App\Core\Database;

class DatabaseConfig {
    private static $db = [
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'port' => '3306',
                'database' => 'psuc_db',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'options' => [
                    \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_NATURAL,
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            ]
        ],
        'default' => 'mysql'
    ];

    public static function get($key = null) {
        if ($key === null) {
            return self::$db;
        }
        return self::$db[$key] ?? null;
    }

    public static function set($key, $value) {
        self::$db[$key] = $value;
    }
}
