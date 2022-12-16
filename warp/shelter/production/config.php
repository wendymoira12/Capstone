<?php

$server = "localhost";
$username = "nbqdsxfp_warp";
$password = "C{22fpbGdk(~";
$database = "nbqdsxfp_warp_capstone";

$conn = mysqli_connect($server, $username, $password, $database);
$db = new PDO('mysql:host=localhost;dbname=' . $database . ';charset=utf8', $username, $password);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>