<?php 

include 'config/database.php'; ?>

<?php 
// Form submit
if (isset($_POST['submit'])) {

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr = 'Email is required';
  } else {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // Validate password
  if (empty($_POST['password'])) {
    $passErr = 'Password is required';
  } else {
    $pass = filter_input(
      INPUT_POST,
      'password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($emailErr) && empty($passErr)) {
    // add to database
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $role = 3;
    $sql = "INSERT INTO user_tbl (user_email, user_password, role_id) VALUES ('$email', '$pass', '$role')";
    if (mysqli_query($conn, $sql)) {
      // success
      header('Location: login.php');
    } else {
      // error
      echo 'Error: ' . mysqli_error($conn);
    }
  }
}

?>

<?php
session_start(); 

if (isset($_POST['submit-login'])) 
{
  $email_login = $_POST['email-login'];
  $pass_login = md5($_POST['password-login']);

  $sql = "SELECT * FROM user_tbl WHERE user_email='$email_login' AND user_password='$pass_login' AND role_id='3'";
  $result = mysqli_query($conn, $sql);
  if($result->num_rows > 0) 
  {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email-login'] = $row['email-login'];
    header("Location: admin_home.html");
  } else
  {
    echo "<script>alert('Oops! Email or Password is incorrect')</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WARP ADMIN LOGIN</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <h1>Admin Login Form</h1>
              <div>
                <input type="email" class="form-control <?php echo !$emailErr ?:
          'is-invalid'; ?>" placeholder="Email" required="" name="email-login"/>
              </div>
              <div>
                <input type="password" class="form-control <?php echo !$passErr ?:
          'is-invalid'; ?>" placeholder="Password" required="" name="password-login"/>
              </div>
              <div>
                <input type="submit" class="btn btn-default submit" name="submit-login">
                <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> WARP ADMIN</h1>
                  <!-- <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p> -->
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <h1>Create Account</h1>
              <div>
                <input type="email" class="form-control <?php echo !$emailErr ?:
          'is-invalid'; ?>" placeholder="Email" required="" name="email"/>
              </div>
              <div>
                <input type="password" class="form-control <?php echo !$passErr ?:
          'is-invalid'; ?>" placeholder="Password" required="" name="password" />
              </div>
              <div>
                <input type="submit" class="btn btn-default submit" name="submit">
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#signin" class="to_register">Log in</a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> WARP ADMIN</h1>
                  <!-- <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p> -->
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
