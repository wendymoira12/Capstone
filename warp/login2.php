<?php 

include 'config.php';

session_start();

if(isset($_POST['submit'])) 
{
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];
  $cnumber = $_POST['cnumber'];
  $region = $_POST['region'];
  $city = $_POST['city'];

  $sql = "INSERT INTO adopter_tbl(adopter_fname, adopter_lname, adopter_age, adopter_cnum, adopter_region, adopter_city) VALUES(?,?,?,?,?,?)";
  $stmtinsert = $db->prepare($sql);
  $result = $stmtinsert->execute([$fname, $lname, $age, $cnumber, $region, $city]);
  if($result)
  {
    echo "<script>alert('Registration complete')</script>";
    header("Location: Home-guest.php");
  } else 
  {
    echo "<script>alert('Oops! Something went wrong')</script>";
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
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
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
                <input type="text" placeholder="First Name" name="fname" required/>
              </div>
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Last Name" name="lname" required/>
              </div>
              <div class="input-field">
                <i class="fa-solid fa-cake-candles"></i>
                <input type="number" placeholder="Age" name="age" required/>
              </div>
              <div class="input-field">
                <i class="fa-solid fa-phone"></i>
                <input type="text" placeholder="Cellphone Number" name="cnumber" required/>
              </div>
              <div class="input-field">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" placeholder="Region" name="region" required/>
              </div>
              <div class="input-field">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" placeholder="City" name="city" required/>
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
          <img src="img/WARP_Logo_Orange.png" class="image" alt="" />
        </div>
        
      </div>
    </div>

    <script src="js/app.js"></script>
  </body>
</html>
