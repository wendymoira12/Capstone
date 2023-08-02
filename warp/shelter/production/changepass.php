<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
  header('Location:/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 2) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/home.php');
  }
}
?>

<?php
// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];

// Get user-email for change pass
$user_email = $_SESSION['user-email'];

// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $city_id = $row['city_id'];
  $sql2 = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result2 = mysqli_query($conn, $sql2);
  if ($result2 == TRUE) {
    $row2 = mysqli_fetch_assoc($result2);
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
  <link rel="shortcut icon" type="image/x-icon" href="/img/WARP_LOGO copy.png">

  <title>Animal Shelter | Account</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Dropzone.js -->
  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/warp/shelter/production/css/style.css">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/warp/shelter/production/css/style.css">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="logo">
          </div>
          <div class="clearfix"></div>


          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <a href="">
              <img src="images/logo.png" alt="">
            </a>
            <div class="profile_pic">
              <img src="/shelter/production/images/logo/<?= $row2['city_img']; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>
                <?php
                echo $row['shelteruser_name'] . ',';
                ?>
                <br>
                <?php
                echo $row['shelteruser_position'];
                ?>
              </h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="shelter_account.php"><i class="fa fa-home"></i> Account </a>
                </li>
                <li><a href="shelter_adoptee_info.php"><i class="fa fa-edit"></i> Add Adoptee info </a>
                </li>
                <li><a href="shelter_adoptee_list.php"><i class="fa fa-paw"></i> Pet Adoptee List </a>
                </li>
                <li><a href="shelter_application_list.php"><i class="fa fa-paw"></i> Application List </a>
                </li>
                <li><a href="shelter_schedule_list.php"><i class="fa fa-paw"></i> Schedule List </a>
                </li>
                <li><a href="shelter_adopted_list.php"><i class="fa fa-paw"></i> Adopted Pet List </a>
                </li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="/shelter/production/images/logo/<?= $row2['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="changepass.php"><i class="fa fa-wrench pull-right"></i>Change Password</a></li>
                  <li><a href="/logout.php?logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/home.php">Go to Homepage </i></a>
                <!-- NOTIF START -->
                <?php
                include "shelter_notif.php";
                ?>
                <!-- NOTIF END -->

          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <!-- top tiles -->
        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <div class="title_left">
                  <h3>Change Password</h3>
                </div>
              </div>
              <div class="x_content">
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?= htmlspecialchars('changepassform.php'); ?>">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="currentpass">Current Password<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="password" id="currentpass" name="curpassword" required="required" class="form-control col-md-7 col-xs-12 <?= !$curpassErr ?: 'is-invalid'; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="newpass">New Password<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="password" pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}" title="Must be at least 8 characters and contain 1 upper and lower case, numeric, and special character" required id="newpass" name="newpassword" required="required" class="form-control col-md-7 col-xs-12 <?= !$newpassErr ?: 'is-invalid'; ?>">
                    </div>
                  </div>
                  <h6> <center> Password must be a minimum of 8 characters, and contain<br> at least 1 upper and lower case, numeric, and special character</center></h6>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmpass">Confirm New Password<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="password" pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}" title="Must be at least 8 characters and contain 1 upper and lower case, numeric, and special character" required id="confirmpass" name="conpassword" required="required" class="form-control col-md-7 col-xs-12 <?= !$conpassErr ?: 'is-invalid'; ?>">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button class="btn btn-primary" type="reset">Reset</button>
                      <button type="submit" class="btn btn-success" name="submit-pass" onclick="return confirm('Are you sure you want to change your password?');"
>Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>


      </div>
      <!-- /page content -->
    </div>
  </div>

  <!-- footer content -->
  <footer>
    <div class="pull-right">
      <!-- Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a> -->
      Copyright &copy; 2023 All rights reserved | UI design by <a href="https://colorlib.com/">Colorlib</a> &#x2764;, Modified by WARP Team
    </div>
    <div class="clearfix"></div>
  </footer>
  <!-- /footer content -->

  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Dropzone.js -->
  <script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
</body>

</html>
