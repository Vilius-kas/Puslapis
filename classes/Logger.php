<?php
require_once 'Database.php';

class Logger {
    public static function log($username, $success) {
        $db = Database::getConnection();
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt = $db->prepare("INSERT INTO login_logs (username, success, ip_address) VALUES (?, ?, ?)");
        $stmt->execute([$username, $success, $ip]);
    }
}
?>
