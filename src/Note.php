<?php
require_once 'db.php';

class Note
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function createNote($username, $title, $content, $category)
    {
        $stmt = $this->db->prepare("INSERT INTO notizen (Username, Titel, Inhalt, Kategorie, date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $title, $content, $category);
        $stmt->execute();
        $stmt->close();
    }

    public function updateNote($noteId, $title, $content, $category)
    {
        $stmt = $this->db->prepare("UPDATE notizen SET Titel = ?, Inhalt = ?, Kategorie = ? WHERE ID = ?");
        $stmt->bind_param("sssi", $title, $content, $category, $noteId);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteNote($noteId)
    {
        $stmt = $this->db->prepare("DELETE FROM notizen WHERE ID = ?");
        $stmt->bind_param("i", $noteId);
        $stmt->execute();
        $stmt->close();
    }

    public function loadNotesByUser($username)
    {
        $stmt = $this->db->prepare("SELECT ID, Titel, Inhalt, Kategorie, date FROM notizen WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $notes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notes;
    }
}
?>
