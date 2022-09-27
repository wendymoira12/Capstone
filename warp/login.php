<?php

include 'config.php';

error_reporting(0);

if(isset($_POST['submit-signup'])) {
  $email_signup = $_POST['email-signup'];
  $pass_signup = md5($_POST['pass-signup']);
  $cpass_signup = md5($_POST['cpass-signup']);

  if($pass_signup == $cpass_signup) 
  {
    $sql = "SELECT * FROM user_tbl WHERE user_email='$email_signup'";
    $result = mysqli_query($conn, $sql);

    if (!$result->num_rows > 0)
    {
        $sql = "INSERT INTO user_tbl (user_email, user_password)
                VALUES ('$email_signup', '$pass_signup')";
        $result = mysqli_query($conn, $sql);
        header("Location: login2.php");
        if ($result) 
        {
          echo "<script>alert('Registration complete')</script>";
          $email_signup = "";
          $_POST['pass-signup'] = "";
          $_POST['cpass-signup'] = "";

        } else 
        {
          echo "<script>alert('Oops! Something went wrong')</script>";
        }
    } else
      {
        echo "<script>alert('Oops! Email already used')</script>";
      }
  } else 
  {
    echo "<script>alert('Password doesnt Match')</script>";
  }
}

session_start();

if (isset($_POST['submit-login'])) 
{
  $email_login = $_POST['email-login'];
  $pass_login = md5($_POST['pass-login']);

  $sql = "SELECT * FROM user_tbl WHERE user_email='$email_login' AND user_password='$pass_login'";
  $result = mysqli_query($conn, $sql);
  if($result->num_rows > 0) 
  {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email-login'] = $row['email-login'];
    header("Location: home.php");
  } else
  {
    echo "<script>alert('Oops! Email or Password is incorrect')</script>";
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
            <input type="email" placeholder="Email" name="email-login" value="<?php echo $email_login; ?>" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="pass-login" value="<?php echo $_POST['pass-login']; ?>" required/>
          </div>
          <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->
          <button name="submit-login" class="btn solid">Login</button>

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
        <form action="" method="POST" class="sign-up-form">
          <h2 class="title">Sign up</h2>

          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email-signup" value="<?php echo $email_signup; ?>" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="pass-signup" value="<?php echo $_POST['pass-signup']; ?>" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="cpass-signup" value="<?php echo $_POST['cpass-signup']; ?>" required />
          </div>
          <button name="submit-signup" class="btn solid" type="submit">Sign Up</button>
          <p class="social-text"></p>
          <div class="social-media">

          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here?</h3>
          <p>
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
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