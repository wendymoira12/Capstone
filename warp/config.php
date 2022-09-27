<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "warp_capstone";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>