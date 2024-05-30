<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kezdőlap</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }
    h1 {
        color: #333;
        text-align: center;
        padding-top: 20px;
    }
    p {
        color: #666;
        text-align: center;
    }
    a {
        color: #0066cc;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    .login-register {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 20px;
    }
</style>
</head>
<body>
    <h1>Üdvözöljük a rajzprogramban!</h1>
    <p>Kérjük, jelentkezzen be vagy regisztráljon.</p>
    <div class="login-register">
        <a href="login.php">Bejelentkezés</a> | <a href="register.php">Regisztráció</a>
    </div>
</body>
</html>