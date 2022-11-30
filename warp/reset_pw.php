
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
        <form action="#" method="POST" name="reset">
        <h2 class="title">Reset Password</h2>
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Current Password" name="current_password" value="" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="New Password" name="new_password" value="" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm New Password" name="cnew_password" value="" required />
          </div>
          <input type="submit" value="Reset Password" name="resetPassword" class="btn solid" />
        </form>
          
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
          <h3>New here?</h3>
            <p>
            </p>
            <a href = "register.php">
            <button class="btn transparent" formaction ="register.php">Sign up</button>
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

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>
