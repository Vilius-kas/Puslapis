<?php
require_once 'Database.php';

class Entry {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addEntry($userId, $title, $comment, $location) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt = $this->db->prepare("INSERT INTO entries (user_id, title, comment, location, ip_address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $comment, $location, $ip]);
    }

    public function getAllEntries() {
        return $this->db->query("SELECT entries.*, users.username FROM entries JOIN users ON entries.user_id = users.id ORDER BY created_at DESC")->fetchAll();
    }

    public function deleteEntry($entryId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM entries WHERE id = ? AND user_id = ?");
        return $stmt->execute([$entryId, $userId]);
    }
}
?>
