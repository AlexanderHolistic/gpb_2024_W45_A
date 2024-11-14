<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Note.php';

$user = new User($db);

if (!$user->isLoggedIn()) {
    exit;
}

$noteModel = new Note($db);
$username = $_SESSION['username'];

$action = $_POST['action'] ?? '';
$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$content = trim($_POST['content'] ?? '');
$noteId = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;

if ($action === 'create') {
    if (!empty($title) && !empty($content)) {
        if ($noteModel->createNote($username, $title, $content, $category)) {
            echo "Note successfully saved!";
        } else {
            echo "Failed to save the note.";
        }
    } else {
        echo "Title and content are required.";
    }
}
?>
