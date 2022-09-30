<?php

session_start();

print_r($_SESSION['user_email']);
print_r($_SESSION['role_id']);
print_r($_SESSION['user_id']);
print_r($_SESSION['user_email2']);
print_r($_SESSION['email-login']);
$roleno = $_SESSION['role_id']; 
$email = $_SESSION['user_email'];
echo $roleno;
echo $email;