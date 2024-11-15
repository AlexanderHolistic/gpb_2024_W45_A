<?php
require_once 'db.php';

class User
{

    public function register($username, $password)
    {
        global $db;

        if ($this->usernameExists($username)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO user (Username, Password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function login($username, $password)
    {
        global $db;

        $id = null;
        $hashedPassword = null;

        $stmt = $db->prepare('SELECT ID, Password FROM user WHERE Username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if ($id && password_verify($password, $hashedPassword)) {
            $this->ensureSessionStarted();
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            return true;
        }
        return false;
    }

    public function logout()
    {
        $this->ensureSessionStarted();
        session_unset();
        session_destroy();
    }

    public function isLoggedIn()
    {
        $this->ensureSessionStarted();
        return isset($_SESSION['user_id']);
    }

    public function getUserId()
    {
        $this->ensureSessionStarted();
        return $_SESSION['user_id'] ?? null;
    }

    private function usernameExists($username)
    {
        global $db;

        $stmt = $db->prepare('SELECT ID FROM user WHERE Username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    private function ensureSessionStarted()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}
