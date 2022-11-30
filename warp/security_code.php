<?php session_start() ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
  <meta charset="UTF-8" />
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/login.css" />
  <title>Sign in & Sign up Form</title>
  <!------ <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> ---------->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
</head>

<body>
  <div class="logo">

  </div>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="#" method="POST">
          <h2 class="title">Verify your Account</h2>
          <h5> Please enter your Security Code here: </h5>
          <div class="input-field">
            <i class="fa-solid fa-lock-hashtag"></i>
            <input type="text" id="otp" class="form-control" name="otp_code" required autofocus>
            <label for="email_address"></label>
          </div>
          <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->

          <button class="btn solid" input type="submit" value="Verify" name="verify">Verify</button>
      </div>

      </form>

    </div>
  </div>

  <div class="panels-container">
    <div class="panel left-panel">
      <div class="content">
        <h3></h3>
        <p>
        </p>

      </div>
      <img src="img/WARP_Logo_Orange.png" class="image" alt="" />
    </div>

    <script src="js/app.js"></script>
</body>

</html>
<?php
include('connect/connection.php');
if (isset($_POST["verify"])) {
  $otp = $_SESSION['otp'];
  $email = $_SESSION['mail'];
  $otp_code = $_POST['otp_code'];

  if ($otp != $otp_code) {
?>
    <script>
      alert("Invalid OTP code");
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("Verify account done, you may reset your password now");
      window.location.replace("reset-pw.php");
    </script>
<?php
  }
}

?>