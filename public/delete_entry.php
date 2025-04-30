<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../classes/Database.php';
require_once '../classes/Entry.php';

$pdo   = Database::getConnection();
$entry = new Entry();

if (isset($_GET['id'])) {
    
    $entry->deleteEntry((int)$_GET['id'], $_SESSION['user_id']);
}

header('Location: dashboard.php');
exit;
