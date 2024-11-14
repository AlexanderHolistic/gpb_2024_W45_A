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
        if ($noteModel->createNote($username, $title, $content)) {
            echo 'success';
        }
    }
} elseif ($action === 'update') {
    if (!empty($title) && !empty($content) && $noteId > 0) {
        if ($noteModel->updateNote($noteId, $title, $content)) {
            echo 'updated';
        }
    }
} elseif ($action === 'delete') {
    if ($noteId > 0) {
        if ($noteModel->deleteNote($noteId)) {
            echo 'deleted';
        }
    }
}
