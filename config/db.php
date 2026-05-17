<?php
$host = 'localhost';
$db   = 'task_management'; // আপনার ডাটাবেসের নাম
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>