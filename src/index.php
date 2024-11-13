<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Note.php';

session_start();

// Prüft, ob der Benutzer eingeloggt ist
$user = new User($db);
if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Erstellt ein neues Note-Objekt
$note = new Note($db);
$username = $_SESSION['username'];

// Verarbeitung von Notiz-Aktionen (Hinzufügen, Bearbeiten, Löschen)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $note->addNote($username, $title, $content);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $noteId = $_POST['noteId'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $note->updateNote($noteId, $title, $content);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $noteId = $_POST['noteId'];
        $note->deleteNote($noteId);
    }
}

// Lädt alle Notizen des Benutzers
$notes = $note->loadNotesByUser($username);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Notizverwaltung</title>
</head>

<body>

    <h1>Willkommen, <?php echo htmlspecialchars($username); ?></h1>
    <p><a href="logout.php">Abmelden</a></p>

    <h2>Neue Notiz hinzufügen</h2>
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="add">
        Titel: <input type="text" name="title" required><br>
        Inhalt: <textarea name="content" required></textarea><br>
        <button type="submit">Notiz hinzufügen</button>
    </form>

    <h2>Deine Notizen</h2>
    <?php if (!empty($notes)): ?>
        <?php foreach ($notes as $note): ?>
            <div>
                <h3><?php echo htmlspecialchars($note['Titel']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($note['Inhalt'])); ?></p>
                <small><?php echo htmlspecialchars($note['date']); ?></small>

                <!-- Formular zum Bearbeiten einer Notiz -->
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="noteId" value="<?php echo $note['ID']; ?>">
                    Titel: <input type="text" name="title" value="<?php echo htmlspecialchars($note['Titel']); ?>" required><br>
                    Inhalt: <textarea name="content" required><?php echo htmlspecialchars($note['Inhalt']); ?></textarea><br>
                    <button type="submit">Notiz aktualisieren</button>
                </form>

                <!-- Formular zum Löschen einer Notiz -->
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="noteId" value="<?php echo $note['ID']; ?>">
                    <button type="submit" onclick="return confirm('Möchten Sie diese Notiz wirklich löschen?')">Notiz löschen</button>
                </form>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Keine Notizen vorhanden.</p>
    <?php endif; ?>

</body>

</html>