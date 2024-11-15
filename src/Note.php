<?php
require_once 'db.php';

class Note
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function createNote($username, $title, $content)
    {
        $stmt = $this->db->prepare('INSERT INTO notizen (Username, Titel, Inhalt, Date) VALUES (?, ?, ?, NOW())');
        $stmt->bind_param('sss', $username, $title, $content);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function updateNote($noteId, $title, $content)
    {
        $stmt = $this->db->prepare('UPDATE notizen SET Titel = ?, Inhalt = ? WHERE ID = ?');
        $stmt->bind_param('ssi', $title, $content, $noteId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function deleteNote($noteId)
    {
        $stmt = $this->db->prepare('DELETE FROM notizen WHERE ID = ?');
        $stmt->bind_param('i', $noteId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function loadNotesByUser($username)
    {
        $stmt = $this->db->prepare('SELECT ID, Titel, Inhalt, Date FROM notizen WHERE Username = ? ORDER BY Date DESC');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $notes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notes;
    }
}
