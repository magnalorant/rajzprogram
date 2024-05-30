<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_SESSION['username']; 
  $target_dir = "users/" . $username . "/";

  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  $dataUrl = $_POST['image'];
  $data = explode(',', $dataUrl)[1];
  $decodedData = base64_decode($data);

  $filename = uniqid() . '.png';
  $target_file = $target_dir . $filename;

  file_put_contents($target_file, $decodedData);
}
?>