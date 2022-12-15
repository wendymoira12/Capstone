<?php

include 'config.php';

session_start();

//Form submit for adopter user creation
if (isset($_POST['submit'])) {

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

  // Validate confirm password
  if (empty($_POST['cpassword'])) {
    $cpassErr = 'Password is required';
  } else {
    $cpassword = filter_input(
      INPUT_POST,
      'cpassword',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];
  $cnumber = $_POST['cnumber'];
  $currentadd = $_POST['currentadd'];
  $permanentadd = $_POST['permanentadd'];
  $email = $_SESSION['mail'];

  //Check if no errors sa pass at confirm pass
  if (empty($passErr) && empty($cpassErr)) {
    //Check if password == confirm password if true insert data into database
    if ($password == $cpassword) {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $role = 1;
      $sql = "INSERT INTO user_tbl (user_email, user_password, role_id) VALUES ('$email', '$password_hash', '$role')";
      $result = mysqli_query($conn, $sql);
      //If the query is false, add user data to database and execute another query for adopter tbl
      if (!$result->num_rows > 0) {
        //Success inserting user account
        //Then ichecheck sa db ung email and role id = 1
        $sql2 = "SELECT * FROM user_tbl WHERE user_email='$email' AND role_id='$role'";
        $result2 = mysqli_query($conn, $sql2);
        //If true then iistore in temp variable si user id to save in adopter table
        if ($result2->num_rows > 0) {
          $row = mysqli_fetch_assoc($result2);
          $_SESSION['user_id'] = $row['user_id'];
          $userid = $_SESSION['user_id'];
          //Then iinsert na ung data sa adopter_tbl
          $sql3 = "INSERT INTO adopter_tbl(adopter_fname, adopter_lname, adopter_age, adopter_cnum, adopter_currentadd, adopter_permanentadd, user_id) VALUES(?,?,?,?,?,?,?)";
          $stmtinsert = $db->prepare($sql3);
          $result3 = $stmtinsert->execute([$fname, $lname, $age, $cnumber, $currentadd, $permanentadd, $userid]);
          //If successful ang insertion mareredirect na sa homepage si adopter
          if ($result3) {
            echo "<script>alert('Registration complete')</script>";
            //$_SESSION['adopter-email'] = $email;
            header("Location: Home-guest.php");
          } else {
            echo "<script>alert('Oops! Something went wrong')</script>";
          }
        } else {
          echo 'Error' . mysqli_error($conn);
        }
      } else {
        echo 'Error' . mysqli_error($conn);
      }
    } else {
      echo "<script>alert('Password doesnt Match')</script>";
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
  <link rel="stylesheet" href="css/login2.css" />
  <title>Complete Registration</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="POST" class="sign-in-form">
          <h2 class="title"> You're almost done!</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="First Name" name="fname" required>
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Last Name" name="lname" required>
          </div>
          <div class="input-field">
            <i class="fa-solid fa-cake-candles"></i>
            <input type="number" placeholder="Age" name="age" required>
          </div>
          <div class="input-field">
            <i class="fa-solid fa-phone"></i>
            <input minlength="11" maxlength="11" type="text" placeholder="Cellphone Number" name="cnumber" required>
          </div>
          <div class="input-field">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" placeholder="Current Address" name="currentadd" required>
          </div>
          <div class="guide">
          <h6> Unit Number, House Number, Street, Barangay, City/Municipality.</h6>
          </div>
          <div class="input-field">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" placeholder="Permanent Address" name="permanentadd" required>  
          </div>
          <div class="guide"> 
            <h6> Unit Number, House Number, Street, Barangay, City/Municipality.</h6>
          </div>
            <div class="input-field">
            <i class="fa-solid fas fa-lock"></i>
            <input type="password" class="<?php echo !$passErr ?: 'is-invalid'; ?>" placeholder="Password" name="password" required>
          </div>
          <div class="input-field">
            <i class="fa-solid fas fa-lock"></i>
            <input type="password" class="<?php echo !$cpassErr ?: 'is-invalid'; ?>" placeholder="Confirm Password" name="cpassword" required>
          </div>

          <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->
          <button name="submit" class="btn solid">submit</button>


        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Thank you for verifying your account. <br> <br>
            Please complete your registration by filling out this form.</h3>
          <p>
          </p>

        </div>
        <img src="img/dog.png" class="image" alt="" />
      </div>

    </div>
  </div>

  <script src="js/app.js"></script>
</body>

</html>