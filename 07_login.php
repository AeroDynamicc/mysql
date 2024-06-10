<?php
session_start();

// Kui administraator on juba sisse loginud, suuname ta administraatori lehele
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit();
}

// Õige parool
$correct_password = "minu_salasona";

// Kui vorm on esitatud
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];

    // Kontrollime, kas sisestatud parool on õige
    if ($password === $correct_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Vale parool!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administraatori sisselogimine</title>
</head>
<body>
    <h2>Administraatori sisselogimine</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
        <label for="password">Parool:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Logi sisse">
    </form>
</body>
</html>
