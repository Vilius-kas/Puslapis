<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../classes/Entry.php';
require_once '../templates/header.php';

$entry = new Entry();
$entries = $entry->getAllEntries();
?>

<h2>Visi įrašai</h2>

<?php foreach ($entries as $e): ?>
    <div class="card mt-2">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($e['title']) ?> (<?= htmlspecialchars($e['username']) ?>)</h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($e['comment'])) ?></p>
            <small>
                <?= $e['created_at'] ?> | 
                IP: <?= htmlspecialchars($e['ip_address']) ?> | 
                Lokacija: <?= htmlspecialchars($e['location']) ?>
            </small><br>

            <?php if ($_SESSION['user_id'] == $e['user_id']): ?>
                <a href="delete_entry.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm mt-2">Trinti</a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php require_once '../templates/footer.php'; ?>
