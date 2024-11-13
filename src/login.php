<?php
require_once 'db.php';
require_once 'User.php';

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Versucht, den Benutzer anzumelden
    if ($user->login($username, $password)) {
        // Nach erfolgreichem Login zur Notizverwaltungsseite weiterleiten
        header('Location: index.php');
        exit;
    } else {
        echo "Anmeldung fehlgeschlagen. Bitte überprüfen Sie Ihren Benutzernamen und Ihr Passwort.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Anmeldung</title>
</head>

<body>

    <h2>Anmelden</h2>
    <form method="post" action="login.php">
        Benutzername: <input type="text" name="username" required><br>
        Passwort: <input type="password" name="password" required><br>
        <button type="submit">Anmelden</button>
    </form>

    <p>Noch kein Konto? <a href="register.php">Hier registrieren</a></p>

</body>

</html>