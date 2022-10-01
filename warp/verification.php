<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/login.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="logo">

    </div>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
        <form action="#" method="POST">
            <h2 class="title">Verify your Account</h2>
            <p> Please enter your OTP Code here: </p>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="otp" class="form-control" name="otp_code" required autofocus>
              <label for="email_address"></label>
            </div>
            <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->
            
             <button class="btn solid" input type="submit" value="Verify" name="verify" >Verify</button>
            </div>

          </form>
          
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>An OTP Code has been sent to your registered email. <br>
          Please verify your account to complete your signing up process.</h3>
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
    if(isset($_POST["verify"])){
        $otp = $_SESSION['otp'];
        $email = $_SESSION['mail'];
        $otp_code = $_POST['otp_code'];

        if($otp != $otp_code){
            ?>
           <script>
               alert("Invalid OTP code");
           </script>
           <?php
        }else{
            mysqli_query($connect, "UPDATE login SET status = 1 WHERE email = '$email'");
            ?>
             <script>
                 alert("Verfiy account done, you may sign in now");
                   window.location.replace("index.php");
             </script>
             <?php
        }

    }

?>