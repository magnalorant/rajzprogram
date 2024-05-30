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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("UPDATE users SET is_approved = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User approved successfully";
    } else {
        echo "Error approving user: " . $stmt->error;
    }
} else {
    echo "No user id provided";
}

$conn->close();
?>