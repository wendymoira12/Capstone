<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "warp_capstone";

$conn = mysqli_connect($server, $username, $password, $database);
$db = new PDO('mysql:host=localhost;dbname=' . $database . ';charset=utf8', $username, $password);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>