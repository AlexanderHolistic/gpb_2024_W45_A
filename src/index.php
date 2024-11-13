<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Note.php';

session_start();

// Prüfen, ob der Benutzer eingeloggt ist
$user = new User($db);
if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Erstellen eines Note-Objekts
$note = new Note($db);
$username = $_SESSION['username'];

// Verarbeitung von Notiz-Aktionen
$action = $_POST['action'] ?? null;
$title = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;
$noteId = $_POST['noteId'] ?? null;

if ($action === 'add' && $title && $content) {
    $note->addNote($username, $title, $content);
} elseif ($action === 'edit' && $noteId && $title && $content) {
    $note->updateNote($noteId, $title, $content);
} elseif ($action === 'delete' && $noteId) {
    $note->deleteNote($noteId);
}

// Laden der Notizen des Benutzers
$notes = $note->loadNotesByUser($username);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Notizverwaltung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Willkommen, <?php echo htmlspecialchars($username); ?></h1>
    <p><a href="logout.php">Abmelden</a></p>

    <h2>Neue Notiz hinzufügen</h2>
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="add">
        <label for="title">Titel:</label>
        <input type="text" name="title" id="title" required>
        <label for="content">Inhalt:</label>
        <textarea name="content" id="content" required></textarea>
        <button type="submit">Notiz hinzufügen</button>
    </form>

    <h2>Deine Notizen</h2>
    <?php if (!empty($notes)): ?>
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <h3><?php echo htmlspecialchars($note['Titel']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($note['Inhalt'])); ?></p>
                <small><?php echo htmlspecialchars($note['date']); ?></small>

                <!-- Bearbeiten-Schaltfläche -->
                <button type="button" onclick="openEditModal('<?php echo $note['ID']; ?>', '<?php echo htmlspecialchars($note['Titel']); ?>', '<?php echo htmlspecialchars($note['Inhalt']); ?>')">Bearbeiten</button>

                <!-- Löschen-Schaltfläche -->
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="noteId" value="<?php echo $note['ID']; ?>">
                    <button type="submit" onclick="return confirm('Möchten Sie diese Notiz wirklich löschen?')">Löschen</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Keine Notizen vorhanden.</p>
    <?php endif; ?>
</div>

<!-- Modal für Notiz bearbeiten -->
<div class="modal-overlay" id="editModalOverlay">
    <div class="modal" id="editModal">
        <span class="modal-close" onclick="closeEditModal()">×</span>
        <h3>Notiz bearbeiten</h3>
        <form id="editNoteForm" method="post" action="index.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="noteId" id="editNoteId">
            <label for="editTitle">Titel:</label>
            <input type="text" name="title" id="editTitle" required>
            <label for="editContent">Inhalt:</label>
            <textarea name="content" id="editContent" required></textarea>
            <button type="submit">Aktualisieren</button>
        </form>
    </div>
</div>

<script src="script.js"></script>

</body>
</html>
