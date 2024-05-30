<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit;
}

$host = "localhost";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli ($host, $dbusername, $dbpassword, 'user_database');

if ($conn->connect_error) {
  die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $hashed_password, $id);
$stmt->execute();

header('Location: admin.php');
exit;

$conn->close();
?>