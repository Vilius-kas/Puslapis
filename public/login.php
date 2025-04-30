<?php
session_start();

require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../templates/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = Database::getConnection();
    $user = new User($pdo);

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($user->login($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Neteisingi prisijungimo duomenys.</div>";
    }
}
?>

<form method="POST">
    <input name="username" class="form-control" placeholder="Vartotojo vardas" required>
    <input name="password" type="password" class="form-control" placeholder="Slaptažodis" required>
    <button class="btn btn-success mt-2">Prisijungti</button>
</form>

<?php require_once '../templates/footer.php'; ?>
