<?php

session_start();

/*
print_r($_SESSION['email-login']);
print_r($_SESSION['password-login']);
print_r($_SESSION['otp']);
print_r($_SESSION['mail'] );

if (password_verify($_SESSION['password2'], $_SESSION['password-login'])) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
} */
//print_r($_SESSION['password-login']);
print_r($_SESSION['user-email']); 
echo '<br>';
print_r($_SESSION['user-role-id']);
echo '<br>';
print_r($_SESSION['user_id']);
echo '<br>';
//print_r($_SESSION['sched_id']);
filter_list();

phpinfo();
