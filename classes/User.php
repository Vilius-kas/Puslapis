<?php
require_once 'Database.php';
require_once 'Logger.php';

class User {
    private $db;
    private $id;
    private $username;
    private $firstname;
    private $lastname;
    private $email;
    private $passwordHash;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($username, $firstname, $lastname, $email, $password) {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (username, firstname, lastname, email, password_hash) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->username, $this->firstname, $this->lastname, $this->email, $this->passwordHash]);
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    
        $ip = $_SERVER['REMOTE_ADDR'];
    
        if ($user && password_verify($password, $user['password_hash'])) {
            $this->logLoginAttempt($username, 1, $ip);
    
            $this->id = $user['id'];
            $this->username = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
    
            return true;
        }
    
        $this->logLoginAttempt($username, 0, $ip);
        return false;
    }
    
    private function logLoginAttempt($username, $success, $ip) {
        $stmt = $this->db->prepare("INSERT INTO login_logs (username, success, ip_address) VALUES (?, ?, ?)");
        $stmt->execute([$username, $success, $ip]);
    }
    

    public function changePassword($userId, $newPassword) {
        $this->passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$this->passwordHash, $userId]);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getId() {
        return $this->id;
    }
}
