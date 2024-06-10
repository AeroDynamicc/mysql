<?php
session_start();

// Kontrollime, kas administraator on sisse loginud
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Andmebaasi ühendus
$servername = "localhost"; // Andmebaasi serveri nimi
$username = "dmeijel"; // Andmebaasi kasutajanimi
$password = "dmeijel"; // Andmebaasi parool
$dbname = "muusikapood"; // Andmebaasi nimi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollime ühenduse õnnestumist
if ($conn->connect_error) {
    die("Ühendus ebaõnnestus: " . $conn->connect_error);
}

// Kui vorm on esitatud
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kontrollime, kas kasutajanimi juba eksisteerib
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $error = "Kasutajanimi on juba olemas!";
    } elseif (strlen($password) < 6) {
        $error = "Parool peab olema vähemalt 6 tähemärki pikk!";
    } else {
        // Krüpteerime parooli ja lisame kasutaja andmebaasi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->close();

        $success = "Kasutaja on edukalt registreeritud!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administraatori leht</title>
</head>
<body>
    <h2>Tere tulemast, administraator!</h2>
    <h3>Registreeri uus kasutaja:</h3>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
    <form method="post" action="">
        <label for="username">Kasutajanimi:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Parool:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Registreeri kasutaja">
    </form>
    <br>
    <a href="logout.php">Logi välja</a>
</body>
</html>
