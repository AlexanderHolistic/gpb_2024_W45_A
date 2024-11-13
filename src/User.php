<?php
require_once 'db.php';

class User
{
    private $db;
    private $userId;
    private $username;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
        
    }

    public function register($username, $password)
    {
        if ($this->usernameExists($username)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO User (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare('SELECT ID, password FROM User WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if ($id && password_verify($password, $hashedPassword)) {
            $this->userId = $id;
            $this->username = $username;
            $_SESSION['user_id'] = $this->userId;
            $_SESSION['username'] = $this->username;
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    private function usernameExists($username)
    {
        $stmt = $this->db->prepare('SELECT ID FROM User WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
}
