<?php

session_start();

/*
print_r($_SESSION['password-login']);
print_r($_SESSION['otp']);
print_r($_SESSION['mail'] );
//print_r($_SESSION['sched_id']);*/

$pass2 = '1234';
$pass1 = '$2y$10$zr/lI/p/pIJJUsaKZEURHO8FrviTK.PChLIB/a0wspxn/jcMETbea';
if (password_verify($pass2, $pass1)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
} 
//print_r($_SESSION['password-login']);
print_r($_SESSION['email-login']);
print_r($_SESSION['user-email']); 
echo '<br>';
print_r($_SESSION['user-role-id']);
echo '<br>';
print_r($_SESSION['user_id']);
echo '<br>';
echo '<br>';
print_r($_SESSION['role_id']);
echo '<br>';
print_r($_SESSION['user_email']);
echo '<br>';
//Date algorithm
date_default_timezone_set("Asia/Manila");

echo "Today is " . date("Y-m-d H:i:s") . "<br>";
echo "Today is " . date("l");
echo '<br>';

$datetoday= date_add(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("30 days"));
$date = date_format($datetoday,"Y-m-d H:i:s");
echo $date;
echo '<br>';
print_r($_SESSION['otp']);
echo '<br>';
print_r($_SESSION['mail']);
echo '<br>';
var_dump($_SESSION);

//Check PHP SESSION COOKIE
//filter_list();
//phpinfo();
