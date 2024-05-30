<?php
session_start();

// Check if the user is logged in and is admin
if (!isset($_SESSION['loggedin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit;
}

$host = "localhost";
$dbusername = "root";
$dbpassword = "";

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, 'user_database');

// Check connection
if ($conn->connect_error) {
  die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

// Get the user id from the URL
$id = $_GET['id'];

// Get the user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Form to edit the user details
echo "<form method='post' action='update_user.php'>";
echo "<label for='username'>Username:</label><br>";
echo "<input type='text' id='username' name='username' value='" . $user['username'] . "'><br>";
echo "<label for='password'>Password:</label><br>";
echo "<input type='password' id='password' name='password'><br>";
echo "<input type='hidden' name='id' value='" . $user['id'] . "'>";
echo "<input type='submit' value='Update'>";
echo "</form>";

$conn->close();
?>