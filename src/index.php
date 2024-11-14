<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Note.php';

session_start();

$user = new User($db);
if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$note = new Note($db);
$username = $_SESSION['username'];

$action = $_POST['action'] ?? null;
$title = $_POST['title'] ?? null;
$category = $_POST['category'] ?? null;
$content = $_POST['content'] ?? null;
$noteId = $_POST['noteId'] ?? null;

if ($action === 'add' && $title && $content) {
    $note->createNote($username, $title, $content, $category);
} elseif ($action === 'update' && $noteId && $title && $content) {
    $note->updateNote($noteId, $title, $content, $category);
} elseif ($action === 'delete' && $noteId) {
    $note->deleteNote($noteId);
}

$notes = $note->loadNotesByUser($username);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>NotizY</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module">
        import {
            openEditModal,
            closeEditModal,
            deleteNote
        } from './js/script.js';

        window.openEditModal = openEditModal;
        window.closeEditModal = closeEditModal;
        window.deleteNote = deleteNote;
    </script>
</head>

<body>
    <header>
        <div class="header-content">
            <img src="images/logo.png" alt="Notizbuch Logo" class="logo">
            <h1>Hallo, <?php echo htmlspecialchars($username); ?></h1>
        </div>
        <form method="post" action="logout.php" class="logout-form">
            <button class="logout-button" type="submit">Abmelden</button>
        </form>
    </header>

    <div class="main-container">
        <div class="content-wrapper">
            <div id="noteForm" class="note-form-container">
                <h2>Neue Notiz hinzufügen</h2><br>
                <form method="post" action="index.php">
                    <input type="hidden" name="action" value="add">
                    <label for="title">Titel:</label><br>
                    <input type="text" name="title" id="title" required>

                    <input type="text" name="category" id="category" placeholder="Kategorie eingeben" required>

                    <textarea name="content" id="content" required></textarea>
                    <button type="submit">Notiz hinzufügen</button>
                </form>
            </div>

            <div class="notes-container">
                <h2>Deine Notizen</h2>
                <?php if (!empty($notes)): ?>
                    <?php foreach ($notes as $note): ?>
                        <div class="note">
                            <h3><?php echo htmlspecialchars($note['Titel']); ?></h3>
                            <p>Kategorie: <?php echo isset($note['Kategorie']) && !empty($note['Kategorie']) ? htmlspecialchars($note['Kategorie']) : 'Keine Kategorie'; ?></p>
                            <p><?php echo nl2br(htmlspecialchars($note['Inhalt'])); ?></p>
                            <small><?php echo htmlspecialchars($note['date']); ?></small>
                            <div class="note-actions">
                                <button type="button" onclick="openEditModal('<?php echo $note['ID']; ?>', '<?php echo htmlspecialchars($note['Titel'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($note['Inhalt'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($note['Kategorie'] ?? '', ENT_QUOTES); ?>')">Bearbeiten</button>
                                <form method="post" action="index.php" class="delete-note-form">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="noteId" value="<?php echo $note['ID']; ?>">
                                    <button type="submit" onclick="return confirm('Möchten Sie diese Notiz wirklich löschen?')">Löschen</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Keine Notizen vorhanden.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="editModalOverlay" class="modal-overlay">
        <div class="modal">
            <span class="modal-close" onclick="closeEditModal()">&times;</span>
            <h3>Notiz bearbeiten</h3>
            <form id="editNoteForm" method="post" action="index.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="editNoteId" name="noteId">

                <label for="editTitle">Titel:</label>
                <input type="text" id="editTitle" name="title" required>

                <label for="editCategory">Kategorie:</label>
                <input type="text" id="editCategory" name="category" required>

                <label for="editContent">Inhalt:</label>
                <textarea id="editContent" name="content" required></textarea>

                <button type="submit" class="edit-button">Speichern</button>
            </form>
        </div>
    </div>

    <footer>
        <p>NotizY © 2024 </p>
    </footer>

    <script>
        function openEditModal(noteId, title, content, category) {
            document.getElementById('editNoteId').value = noteId;
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editCategory').value = category;  
            document.getElementById('editModalOverlay').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModalOverlay').style.display = 'none';
        }
    </script>
</body>

</html>