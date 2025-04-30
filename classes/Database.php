<?php
class Database {
    private static ?\PDO $conn = null;

    public static function getConnection(): \PDO {
        if (!self::$conn) {
            $config = require __DIR__ . '/../config/config.php';
            self::$conn = new PDO(
                $config['dsn'],
                $config['username'],
                $config['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$conn;
    }
}
