<?php
    include('connect/connection.php');

    if(isset($_POST["login"])){
        $email = mysqli_real_escape_string($connect, trim($_POST['email']));
        $password = trim($_POST['password']);

        $sql = mysqli_query($connect, "SELECT * FROM login where email = '$email'");
        $count = mysqli_num_rows($sql);

            if($count > 0){
                $fetch = mysqli_fetch_assoc($sql);
                $hashpassword = $fetch["password"];
    
                if($fetch["status"] == 0){
                    ?>
                    <script>
                        alert("Please verify email account before login.");
                    </script>
                    <?php
                }else if(password_verify($password, $hashpassword)){
                    ?>
                    <script>
                        alert("login in successfully");
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        alert("email or password invalid, please try again.");
                    </script>
                    <?php
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
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
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
        <form action="#" method="POST" name="login">
            <h2 class="title">Login to WARP</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="email_address" class="form-control" placeholder="Email Address" name="email" required autofocus>
              <label for="email_address" ></label>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
              <label for="password" ></label>
            </div>
            <!--
            <input type="submit" value="Login" action="home.html" class="btn solid" /> -->
            
             <button class="btn solid" input type="submit" value="Login" name="login">Login</button>
            </div>

          </form>
          
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Not registered yet?</h3>
            <p>
            </p>
            <a href = "register.php">
            <button class="btn transparent" formaction ="register.php">Sign in</button>
            </a> 
          </div>
          <img src="img/WARP_LOGO copy.png" class="image" alt="" />
        </div>
        
    <script src="js/app.js"></script>
  </body>
</html>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>
