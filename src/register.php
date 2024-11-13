<?php
require_once 'db.php';
require_once 'User.php';

$user = new User($db);

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    if ($user->register($username, $password)) {
        header('Location: login.php');
        exit;
    } else {
        echo "<p class='error-message'>Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen Benutzernamen.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Registrieren</title>
</head>

<body>
    <div class="logo-container">
        <img src="images/logo.png" alt="Notizbuch Logo" class="logoLogReg">
    </div>
    <br><br><br><br><br><br>

    <div class="login-container">
        <h2>Registrieren</h2>
        <form method="post" action="register.php" class="login-form">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" id="username" required><br>
            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password" required><br>
            <button type="submit" class="register-button">Registrieren</button>
        </form>
        <p class="login-link">Bereits registriert? <a href="login.php">Hier anmelden</a></p>
    </div>
    </div>
</body>

</html>