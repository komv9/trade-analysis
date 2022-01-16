<?php
$user = 'root';
$password='';
$database='experience';
$servername='localhost:3306';
$mysqli = mysqli_connect($servername, $user, $password, $database);

if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>