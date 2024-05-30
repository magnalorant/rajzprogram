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
  
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
  
echo "<table>";
echo "<tr><th>Username</th><th>Password</th><th>Approved</th><th>Admin</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['password'] . "</td>";
    echo "<td>" . ($row['is_approved'] ? 'Yes' : 'No') . "</td>";
    echo "<td>" . ($row['is_admin'] ? 'Yes' : 'No') . "</td>";
    echo "<td>";
    if (!$row['is_approved']) {
        echo "<a href='approve_user.php?id=" . $row['id'] . "'>Approve</a> ";
    }
    echo "<a href='delete_user.php?id=" . $row['id'] . "'>Delete</a> ";
    echo "<a href='edit_user.php?id=" . $row['id'] . "'>Edit</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
  
$conn->close();
?>