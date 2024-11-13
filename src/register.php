<?php
require_once 'db.php';
require_once 'User.php';

$user = new User($db);

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    // Versucht, den Benutzer zu registrieren
    if ($user->register($username, $password)) {
        // Nach erfolgreicher Registrierung zur Login-Seite weiterleiten
        header('Location: login.php');
        exit;
    } else {
        echo "Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen Benutzernamen.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
</head>

<body>

    <h2>Registrieren</h2>
    <form method="post" action="register.php">
        Benutzername: <input type="text" name="username" required><br>
        Passwort: <input type="password" name="password" required><br>
        <button type="submit">Registrieren</button>
    </form>

    <p>Bereits registriert? <a href="login.php">Hier anmelden</a></p>

</body>

</html>