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
$content = trim($_POST['content'] ?? '');
$noteId = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;

if ($action === 'create') {
    if (!empty($title) && !empty($content)) {
        echo $noteModel->createNote($username, $title, $content) ? 'success' : 'error';
    }
} elseif ($action === 'update') {
    if (!empty($title) && !empty($content) && $noteId > 0) {
        echo $noteModel->updateNote($noteId, $title, $content) ? 'updated' : 'error';
    }
} elseif ($action === 'delete') {
    if ($noteId > 0) {
        echo $noteModel->deleteNote($noteId) ? 'deleted' : 'error';
    }
}
