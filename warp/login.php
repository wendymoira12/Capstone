<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_POST['submit-login'])) {
  $email_login = $_POST['email-login'];
  $pass_login = $_POST['pass-login'];
  $role_adopter = 1;
  $role_shelter = 2;
  $_SESSION['password2'] = $pass_login;
  $sql = "SELECT * FROM user_tbl WHERE (user_email='$email_login' AND role_id='$role_adopter') OR (user_email='$email_login' AND role_id='$role_shelter')";
  $result = mysqli_query($conn, $sql);
  //If the query is true, sql will fetch all the data in the row
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    //Store User Email and its role for user functions
    $_SESSION['user-email'] = $row['user_email'];
    $_SESSION['user-role-id'] = $row['role_id'];
    $_SESSION['user_id'] = $row['user_id'];
    // The password will be stored in the session variable
    $_SESSION['password-login'] = $row['user_password'];
    $hashpass = $_SESSION['password-login'];
    // To check if $pass_login == $hashpass(session variable)
    if (password_verify($pass_login, $hashpass)) {
      unset($_SESSION['password-login']);
      header("Location: home.php");
    } else {
      echo "<script>alert('Incorrect Email or Password')</script>";
    }
  } else {
    echo "<script>alert('Oops! Email or Password is incorrect')</script>";
    echo 'Error: ' . mysqli_error($conn);
  }
}

?>

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
</head>

<body>
  <div class="logo">

  </div>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="POST" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" placeholder="Email" name="email-login" value="<?php echo $email_login; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="pass-login" required />
          </div>
          <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->
          <button type="submit" name="submit-login" class="btn solid">Login</button>

          <!--<a href="#">Forgot Password</a>
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>-->
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here?</h3>
          <p>
          </p>
          <a href="register.php">
          <button name class="btn transparent" id="sign-up-btn">
            Sign up
          </button></a>
        </div>
        <img src="img/WARP_Logo_Orange.png" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Already one of us?</h3>
          <p>
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="img/WARP_LOGO copy.png" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="js/app.js"></script>
</body>

</html>