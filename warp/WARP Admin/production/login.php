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
    $password = filter_input(
      INPUT_POST,
      'password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($emailErr) && empty($passErr)) {
    //Check if username exists
    $sql = "SELECT * FROM user_tbl WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    // Add to database
    if (!$result->num_rows > 0) {
      $pass = password_hash($password, PASSWORD_DEFAULT);
      $role = 3;
      $sql = "INSERT INTO user_tbl (user_email, user_password, role_id) VALUES ('$email', '$pass', '$role')";
      if (mysqli_query($conn, $sql)) {
        // success
        header('Location: login.php');
      } else {
        // error
        echo 'Error: ' . mysqli_error($conn);
      }
    } else {
      echo "<script>alert('Oops! Email already used')</script>";
    }
  }
}

?>

<?php
session_start();
session_regenerate_id();
if (isset($_POST['submit-login'])) {
  $email_login = $_POST['email-login'];
  $pass_login = $_POST['password-login'];
  $role_login = 3;
  //Fetch muna si user_email pati role_id to check if the user exist
  $sql = "SELECT * FROM user_tbl WHERE user_email='$email_login' AND role_id='$role_login'";
  $result = mysqli_query($conn, $sql);
  // If the query is true, sql will fetch all the data in the row
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email-login'] = $row['user_email'];
    $_SESSION['user-role-id'] = $row['role_id'];
    // The password will be stored in the session variable
    $_SESSION['password-login'] = $row['user_password'];
    $hashpass = $_SESSION['password-login'];
    // To check if $pass_login == $hashpass(session variable)
    if (password_verify($pass_login, $hashpass)){
      unset($_SESSION['password-login']);
      header('Location: admin_home.php');
    } else {
      echo "<script>alert('Oops! Email or Password is incorrect')</script>";
    }
  } else {
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
  <link rel="shortcut icon" type="image/x-icon" href="/warp/img/WARP_Logo_Orange.png">
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
                                                        'is-invalid'; ?>" placeholder="Email" required="" name="email-login" />
            </div>
            <div>
              <input type="password" class="form-control <?php echo !$passErr ?:
                                                            'is-invalid'; ?>" placeholder="Password" required="" name="password-login" />
            </div>
            <div>
              <button type="submit" class="btn btn-light border border-secondary" name="submit-login">Submit</button>
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
                                                        'is-invalid'; ?>" placeholder="Email" required="" name="email" />
            </div>
            <div>
              <input type="password" class="form-control <?php echo !$passErr ?:
                                                            'is-invalid'; ?>" placeholder="Password" required="" name="password" />
            </div>
            <div>
              <button type="submit" class="btn btn-light border border-secondary" name="submit">Submit</button>
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