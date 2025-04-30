<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../classes/Database.php';
require_once '../classes/Entry.php';
require_once '../templates/header.php';

$pdo   = Database::getConnection();
$entry = new Entry();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']    ?? '');
    $comment  = trim($_POST['comment']  ?? '');
    $location = trim($_POST['location'] ?? '');

    if ($entry->addEntry($_SESSION['user_id'], $title, $comment, $location)) {
        echo "<div class='alert alert-success'>Įrašas pridėtas.</div>";
    } else {
        echo "<div class='alert alert-danger'>Nepavyko pridėti įrašo.</div>";
    }
}
?>

<form method="POST">
    <input name="title" class="form-control" placeholder="Antraštė" required>
    <textarea name="comment" class="form-control mt-2" placeholder="Komentaras" required></textarea>
    <input name="location" class="form-control mt-2" placeholder="Vieta">
    <button class="btn btn-primary mt-2">Pridėti</button>
</form>

<?php require_once '../templates/footer.php'; ?>
