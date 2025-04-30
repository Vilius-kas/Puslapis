<?php
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/PasswordGenerator.php';
require_once '../templates/header.php';

$db = Database::getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?: PasswordGenerator::generate();
    if ($user->register($_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $password)) {
        echo "<div class='alert alert-success'>Registracija sėkminga. Slaptažodis: $password</div>";
    } else {
        echo "<div class='alert alert-danger'>Registracija nepavyko.</div>";
    }
}
?>

<form method="POST" class="form">
    <input name="username" class="form-control" placeholder="Slapyvardis" required>
    <input name="firstname" class="form-control" placeholder="Vardas" required>
    <input name="lastname" class="form-control" placeholder="Pavardė" required>
    <input name="email" class="form-control" type="email" placeholder="El. paštas" required>
    <input name="password" class="form-control" placeholder="Slaptažodis (palikite tuščią automatiniam)">
    <button class="btn btn-primary mt-2">Registruotis</button>
</form>

<?php require_once '../templates/footer.php'; ?>
