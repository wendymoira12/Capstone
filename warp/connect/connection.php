<?php 

define('DB_SERVER', 'localhost');
define('DB_USER', 'nbqdsxfp_warp');
define('DB_PASS', 'C{22fpbGdk(~');
define('DB_NAME', 'nbqdsxfp_warp_capstone');

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}
?>