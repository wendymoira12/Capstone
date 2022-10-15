<?php session_start(); ?>
<?php
include('connect/connection.php');

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

      $mail->setFrom('warp.pup@gmail.com', 'OTP Verification');
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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/login.css" />
  <title>Sign in & Sign up Form</title>
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
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2 class="title">Register to WARP</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="email_address" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" placeholder="Email Address" name="email" required autofocus>
              <label for="email_address"></label>
            </div>
            <!-- <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" class="form-control <?php echo !$passErr ?: 'is-invalid'; ?>" placeholder="Password" name="password" required>
              <label for="password"></label>
            </div> -->
            <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->

            <button class="btn solid" input type="submit" value="Register" name="register">Register</button>
        </div>

        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Already one of us?</h3><br>
          <a href="login.php">
            <button class="btn transparent">Sign in</button>
          </a>
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