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

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: admin.php');
exit;

$conn->close();
?>