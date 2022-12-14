<?php session_start(); ?>
<?php
include('connect/connection.php');

if (isset($_POST["forgot-pw"])) {

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr  = 'Email is required';
  } else {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // If emailErr is empty, execute query
  if (empty($emailErr)) {
    $sql = "SELECT * FROM user_tbl WHERE user_email = ? AND deleted_at IS NULL ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo '<script>alert("SQL Prepared Statement Failed")</script>';
    } else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        // If the query is true, email already exists
        if ($rowCount > 1) {
?>
          <script>
            alert("User with email doesn't exist!");
          </script>
          <?php
        } else {
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
          $mail->Subject = "WARP: Forgot Password";
          $mail->Body = "<p>Dear user, </p> 
      It seems like you forgot your password for WARP. If this is true, enter the code below to reset your password<h3> $otp <br></h3>
                    <p> If you didn't request this, you can disregard this email or you can let us know.</p>
                    <br><br>
                    <p>Welcome to WARP!</p>
                    <b>WARP Team</b>";

          if (!$mail->send()) {
          ?>
            <script>
              alert("<?php echo "Email doesn't Exist " ?>");
            </script>
          <?php
          } else {
          ?>
            <script>
              alert("<?php echo "Verification code sent to " . $email ?>");
              window.location.replace('security_code.php');
            </script>
<?php
          }
        }
      }
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
  <title>Forgot Password</title>
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
            <h2 class="title">Enter your Email Address</h2>
            <p>Please enter your email to receive a verification code. WARP will send you the code to confirm your account. </p>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="email_address" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" placeholder="Email Address" name="email" required autofocus>
              <label for="email_address"></label>
            </div>
            <button class="btn solid" input type="submit" value="forgot-pw" name="forgot-pw">submit</button>
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