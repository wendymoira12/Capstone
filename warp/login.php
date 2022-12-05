<?php

include 'config.php';

error_reporting(0);

session_start();
session_regenerate_id();
if (isset($_POST['submit-login'])) {
  $email_login = $_POST['email-login'];
  $pass_login = $_POST['pass-login'];
  $role_adopter = 1;
  $role_shelter = 2;
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

if (isset($_POST["register"])) {

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr  = 'Email is required';
  } else {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }
  /*
  // Validate password
  if (empty($_POST['password'])) {
    $passErr = 'Password is required';
  } else {
    $password = filter_input(
      INPUT_POST,
      'password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }
  */
  //$password = $_POST["password"];


  // If emailErr is empty, execute query
  if (empty($emailErr)) {
    $sql = "SELECT * FROM user_tbl where user_email ='$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    // If the query is true, email already exists
    if ($rowCount > 0) {
?>
      <script>
        alert("User with email already exist!");
      </script>
      <?php
    } else {
      //$password_hash = password_hash($password, PASSWORD_DEFAULT);
      //$role = 1;
      //$sql = "INSERT INTO user_tbl (user_email, user_password, role_id) VALUES ('$email', '$password_hash', '$role')";
      //$result = mysqli_query($conn, $sql);

      //if ($result) {
      $otp = rand(100000, 999999);
      $_SESSION['otp'] = $otp;
      $_SESSION['mail'] = $email;
      require "Mail/phpmailer/PHPMailerAutoload.php";
      $mail = new PHPMailer;

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls';

      $mail->Username = 'warp.pup@gmail.com';
      $mail->Password = 'zulriaypcszobrgp';

      $mail->setFrom('warp.pup@gmail.com', 'WARP');
      $mail->addAddress($_POST["email"]);

      $mail->isHTML(true);
      $mail->Subject = "Your OTP code";
      $mail->Body = "<p>Dear user, </p> 
                    Thank you for signing up to WARP. Use the following OTP Code to complete your Sign Up procedures. 
                  The code is valid for 5 minutes.<h3> $otp <br></h3>
                    <p> If you didn't request this, you can disregard this email or you can let us know.</p>
                    <br><br>
                    <p>Welcome to WARP!</p>
                    <b>WARP Team</b>";

      if (!$mail->send()) {
      ?>
        <script>
          alert("<?php echo "Register Failed, Invalid Email " ?>");
        </script>
      <?php
      } else {
      ?>
        <script>
          alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
          window.location.replace('verification.php');
        </script>
<?php
      }
      //}
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
          <p style="display: flex;justify-content: center;align-items: center;margin-top: 20px;"><a href="forgot_pw.php" style="color: #4590ef;">Forgot Password?</a></p>

        </form>
        <form action="#" class="sign-up-form" method="POST">
          <h2 class="title">Register to WARP</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" id="email_address" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" placeholder="Email Address" name="email" required autofocus>
            <label for="email_address"></label>
          </div>
          <button class="btn solid" input type="submit" value="Register" name="register">Register</button>
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
          <br>
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