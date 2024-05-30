<?php
session_start(); 

$host = "localhost";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli ($host, $dbusername, $dbpassword);

if ($conn->connect_error) {
  die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS user_database";
if ($conn->query($sql) === TRUE) {
  //echo "Database created successfully or already exists<br>";
} else {
  //echo "Error creating database: " . $conn->error;
}

$conn->select_db("user_database");

$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL,
  is_approved INT(1) NOT NULL DEFAULT 0,
  is_admin INT(1) NOT NULL DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
  //echo "Table users created successfully or already exists<br>";
} else {
  //echo "Error creating table: " . $conn->error;
}

$sql = "SHOW COLUMNS FROM users LIKE 'is_approved'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $sql = "ALTER TABLE users ADD is_approved INT(1) NOT NULL DEFAULT 0";
    if ($conn->query($sql) === TRUE) {
        echo "Column is_approved added successfully<br>";
    } else {
        echo "Error adding column: " . $conn->error;
    }
}

$sql = "SHOW COLUMNS FROM users LIKE 'is_admin'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $sql = "ALTER TABLE users ADD is_admin INT(1) NOT NULL DEFAULT 0";
    if ($conn->query($sql) === TRUE) {
        echo "Column is_admin added successfully<br>";
    } else {
        echo "Error adding column: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, password, is_approved, is_admin) values (?, ?, 0, 0)");
  $stmt->bind_param("ss", $username, $password);

  if ($stmt->execute()){
    echo "New record is inserted successfully";
    // After successful registration
    $_SESSION['loggedin'] = true;

    // Create a directory for the user
    $userDir = "users/" . $username;
    if (!is_dir($userDir)) {
      mkdir($userDir, 0777, true);
    }

    header('Location: login.php');
    exit;
  }
  else{
    echo "Error: ". $stmt->error;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Regisztráció</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }
    .register-form {
        width: 300px;
        margin: 0 auto;
        padding: 30px 0;
    }
    .register-form input[type="text"], .register-form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
    }
    .register-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #0066cc;
        color: white;
        border: none;
        cursor: pointer;
    }
    .register-form input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <div class="register-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Username: <input type="text" name="username">
            <br>
            Password: <input type="password" name="password">
            <br>
            <input type="submit" name="submit" value="Register">  
        </form>
    </div>
</body>
</html>