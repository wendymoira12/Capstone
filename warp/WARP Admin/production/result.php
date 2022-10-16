<?php

session_start();


print_r($_SESSION['email-login']);
print_r($_SESSION['password-login']);
print_r($_SESSION['otp']);
print_r($_SESSION['mail'] );
/*
if (password_verify($_SESSION['password2'], $_SESSION['password-login'])) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
} */
//print_r($_SESSION['password-login']);
print_r($_SESSION['user-email']);
print_r($_SESSION['user-role-id']);
print_r($_SESSION['user_id']);
print_r($_SESSION['city_name']);
