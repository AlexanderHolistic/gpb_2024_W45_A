<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Note.php';

$user = new User($db);

if (!$user->isLoggedIn()) {
    echo 'unauthorized';
    exit;
}

$noteModel = new Note($db);

$userId = $user->getUserId();
$action = $_POST['action'] ?? '';
$noteText = $_POST['note'] ?? '';
$noteId = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;

if ($action === 'create') {
    if (!empty(trim($noteText))) {
        if ($noteModel->createNote($userId, $noteText)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} elseif ($action === 'update') {
    if (!empty(trim($noteText)) && $noteId > 0) {
        if ($noteModel->updateNote($noteId, $userId, $noteText)) {
            echo 'updated';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} elseif ($action === 'delete') {
    if ($noteId > 0) {
        if ($noteModel->deleteNote($noteId, $userId)) {
            echo 'deleted';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'invalid_action';
}
?>
