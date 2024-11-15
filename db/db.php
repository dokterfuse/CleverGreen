<?php

$host = 'localhost';
$dbname = 'CleverGreenDB';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8 for international characters
echo ("connection is succesfull");
$conn->set_charset("utf8");
?>
