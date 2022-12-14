<?php

include('connect/connection.php');
session_start();

if (!isset($_SESSION['mail'])) {
  header('Location: login.php');
}

if (isset($_POST['resetPassword'])) {

  // Validate current password
  if (empty($_POST['new_password'])) {
    $newpassErr = 'New Password is required';
  } else {
    $newpass = filter_input(
      INPUT_POST,
      'new_password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate current password
  if (empty($_POST['cnew_password'])) {
    $cnewpassErr = 'Confirm New Password is required';
  } else {
    $cnewpass = filter_input(
      INPUT_POST,
      'cnew_password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }
  $email = $_SESSION['mail'];

  if (empty($newpassErr) && empty($cnewpassErr)) {
    if ($newpass == $cnewpass) {
      $pass = password_hash($newpass, PASSWORD_DEFAULT);
      $sql2 = "UPDATE user_tbl SET user_password = ? WHERE user_email = ? AND deleted_at IS NULL";
      $stmt2 = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        echo "SQL Prepared Statement Failed";
      } else {
        mysqli_stmt_bind_param($stmt2, "ss", $pass, $email);
        mysqli_stmt_execute($stmt2);
        unset($_SESSION['otp'], $_SESSION['mail']);
        echo "<script>alert('Password Changed Successfully!')</script>";
        echo "<script>window.location.href='login.php';</script>";
      }
    } else {
      echo "<script>alert('Your new password doesnt match with the confirm new password!')</script>";
      echo "<script>window.location.href='reset_pw.php';</script>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
  <meta charset="UTF-8" />
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/login.css" />
  <title>Reset Password</title>
  <style>


  </style>
</head>

<body>
  <div class="fullscreen">
    <div class="logo">

    </div>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" method="POST" name="reset">
            <h2 class="title">Reset Password</h2>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="New Password" name="new_password" value="" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Confirm New Password" name="cnew_password" value="" required />
            </div>
            <input type="submit" value="Reset Password" name="resetPassword" class="btn solid" />
          </form>

        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
          </div>
          <img src="img/WARP_Logo_Orange.png" class="image" alt="" />
        </div>

        <script src="js/app.js"></script>
</body>

</html>

<script>
  const toggle = document.getElementById('togglePassword');
  const password = document.getElementById('password');

  toggle.addEventListener('click', function() {
    if (password.type === "password") {
      password.type = 'text';
    } else {
      password.type = 'password';
    }
    this.classList.toggle('bi-eye');
  });
</script>