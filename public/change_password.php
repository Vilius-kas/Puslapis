<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../templates/header.php';

$pdo = Database::getConnection();
$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    if ($user->changePassword($_SESSION['user_id'], $newPassword)) {
        echo "<div class='alert alert-success'>Slaptažodis pakeistas sėkmingai.</div>";
    } else {
        echo "<div class='alert alert-danger'>Klaida keičiant slaptažodį.</div>";
    }
}
?>

<form method="POST">
    <input name="new_password" type="password" class="form-control" placeholder="Naujas slaptažodis" required>
    <button class="btn btn-warning mt-2">Keisti slaptažodį</button>
</form>

<?php require_once '../templates/footer.php'; ?>
