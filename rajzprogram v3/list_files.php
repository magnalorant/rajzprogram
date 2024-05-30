<?php
session_start();

$username = $_SESSION['username'];
$dir = "users/$username/";

$files = array_diff(scandir($dir), array('.', '..'));

header('Content-Type: application/json');
echo json_encode($files);
?>