<?php
session_start(); 

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_database";

$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);

  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      if ($user['is_approved'] == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; 
        $_SESSION['is_admin'] = $user['is_admin']; // Add this line
        if ($user['is_admin'] == 1) {
          header('Location: admin.php');
        } else {
          header('Location: index.php');
        }
        exit;
      } else {
        $error = "Your account is not approved yet.";
      }
    } else {
      $error = "Invalid username or password.";
    }
  } else {
    $error = "Invalid username or password.";
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bejelentkezés</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }
    .login-form {
        width: 300px;
        margin: 0 auto;
        padding: 30px 0;
    }
    .login-form input[type="text"], .login-form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
    }
    .login-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #0066cc;
        color: white;
        border: none;
        cursor: pointer;
    }
    .login-form input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .error {
        color: red;
        text-align: center;
    }
</style>
</head>
<body>
    <div class="login-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Username: <input type="text" name="username">
            <br>
            Password: <input type="password" name="password">
            <br>
            <input type="submit" name="submit" value="Login">  
        </form>
        <?php
        if (!empty($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>
    </div>
</body>
</html>