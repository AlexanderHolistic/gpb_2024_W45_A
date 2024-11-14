<?php
require_once 'db.php';
require_once 'User.php';

$user = new User($db);

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    if ($user->login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        echo "<p class='error-message'>Anmeldung fehlgeschlagen. Bitte überprüfen Sie Ihren Benutzernamen und Ihr Passwort.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Anmeldung</title>
</head>

<body>
    <div class="logo-container">
        <img src="images/logo.png" alt="Notizbuch Logo" class="logoLogReg">
    </div>
    <br><br><br><br><br><br>

    <div class="login-container">
        <h2>Anmelden</h2>
        <form method="post" action="login.php" class="login-form">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" id="username" required><br>
            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password" required><br>
            <button type="submit" class="login-button">Anmelden</button>
        </form>
        <p class="register-link">Noch kein Konto? <a href="register.php">Hier registrieren</a></p>
    </div>
</body>

</html>