<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
  header('Location:/Capstone/warp/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 2) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/Capstone/warp/home.php');
  }
}
?>

<?php
// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];
// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $city_id = $row['city_id'];
  $sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result = mysqli_query($conn, $sql);
  if ($result == TRUE) {
    $row = mysqli_fetch_assoc($result);
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
  <link rel="shortcut icon" type="image/x-icon" href="/Capstone/warp/img/WARP_LOGO copy.png">

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
  <link href="../build/css/custom1.min.css" rel="stylesheet">
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
              <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt="..." class="img-circle profile_img">
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
                  <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="changepass.php"><i class="fa fa-wrench pull-right"></i>Change Password</a></li>
                  <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
                <!-- Notification bell -->
                <?php

                $sql_get = mysqli_query($conn, "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, shelternotif_tbl.message, adoptee_tbl.pet_name FROM shelternotif_tbl INNER JOIN applicationform1 ON shelternotif_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE shelternotif_tbl.status = '0' AND applicationform1.application_id = shelternotif_tbl.application_id AND adoptee_tbl.city_id = '$city_id'");
                $count = mysqli_num_rows($sql_get);

                ?>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  <span class="badge bg-green"><?php echo $count; ?></span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <?php
                  if (mysqli_num_rows($sql_get) > 0) {
                    while ($notif = mysqli_fetch_assoc($sql_get)) {
                  ?>
                      <li>
                        <a>
                          <span class="image"><img src="images/user.png" alt="Profile Image" /></span>
                          <span>
                            <span><?php echo $notif['adopter_fname'] . ' ' . $notif['adopter_lname']; ?></span>
                            <!-- <span class="time">3 mins ago</span> -->
                          </span>
                          <span class="message">
                            <?php echo $notif['message'] . ' ' . $notif['pet_name']; ?>
                          </span>
                        </a>
                      </li>
                  <?php
                    }
                  } else {
                    echo '<a > Sorry! No Notifications to show </a>';
                  }
                  ?>
                </ul>
              </li>

          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <!-- top tiles -->

        <div class="row tile_count">
          <?php
          // Make a query to get the total registered adoptees by COUNTing all the adoptees with city id == which shelter city id
          $sql = "SELECT COUNT(pet_id) AS totaladoptee FROM adoptee_tbl WHERE city_id = '$city_id'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $data = mysqli_fetch_assoc($result);
            $totaladoptee = $data['totaladoptee'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-paw"></i> Total Adoptee Pets</span>
            <div class="count"><?= $totaladoptee ?></div>
          </div>

          <?php
          // Make a query to get the total adopted pets by COUNTing all the adopted_id with city id == which shelter city id
          $sql = "SELECT COUNT(adopted_id) AS totaladoptedpet FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$city_id'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $data = mysqli_fetch_assoc($result);
            $totaladoptedpet = $data['totaladoptedpet'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-paw"></i> Total Adopted Pets</span>
            <div class="count"><?= $totaladoptedpet ?></div>
          </div>

          <?php
          // Make a query to get the total applications by COUNTing all the application_id with city id == which shelter city id
          $sql = "SELECT COUNT(application_id) AS totalapplications FROM applicationform1 INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $data = mysqli_fetch_assoc($result);
            $totalapplications = $data['totalapplications'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Applications</span>
            <div class="count"><?= $totalapplications ?></div>
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">

                <div class="title_left">
                  <h3>Shelter Account Page</h3>
                </div>

                <div class="title_right">

                </div>
              </div>

              <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="product-image">
                  <?php echo '<img src="images/logo/' . $row['city_img'] . '" alt="shelter logo"'; ?>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12" style="border:0px solid #e5e5e5;">
              <h3 class="x_title"><?php echo $row['city_name']; ?> </h3>
              <div class="clearfix"></div>
              <h2>About us</h2>
              <p><?php echo $row['city_about']; ?></p>
              <br>
              <h2>Contact us</h2>
              <p><?php echo $row['city_contact']; ?></p>
              <br>
              <h2>Email Address</h2>
              <p> <!-- email add here --> </p>
              <br>
              <a href="shelter_account_edit.php?city_id=<?php echo $row['city_id']; ?>">
                <button type="button" class="btn btn-success btn-primary" onclick="return confirm('Are you sure you want to edit shelter information?');">Edit Information</button>
              </a>
            </div>
          </div>
        </div>
      </div>


      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          <!-- Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a> -->
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>

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