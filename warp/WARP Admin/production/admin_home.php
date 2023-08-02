<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['email-login'])) {
  header('Location: login.php');
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
  <title>WARP Admin</title>
  
  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">

</head>

<!-- Nav Sidebar  -->

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="admin_home.php" class="site_title"><i class="fa fa-paw"></i> <span>WARP</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/WARP_LOGO.svg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>
                <?php
                //DISPLAY SESSION
                if (isset($_SESSION['email-login'])) {
                  echo $_SESSION['email-login'];
                } else {
                  header("Location: login.php");
                }
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
                <li><a><i class="fa fa-home"></i> Home </a></li>
                <li><a href="manage_city.php"><i class="fa fa-building-o"></i> Manage Cities </a></li>
                <li><a><i class="fa fa-users"></i> Manage Accounts </a>
                  <ul class="nav child_menu">
                    <li><a href="manage_shelter.php">Shelter</a></li>
                    <li><a href="manage_adopter.php">Adopter</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-print"></i> Generate Reports <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="report_admin_adoptee_list.php"><i class="fa fa-table"></i>Adoptee List</a>
                    <li><a href="report_admin_application_list.php"><i class="fa fa-table"></i>Application List</a>
                    <li><a href="report_admin_schedule_list.php"><i class="fa fa-table"></i>Schedule List</a>
                    <li><a href="report_admin_adopted_list.php"><i class="fa fa-table"></i>Adopted List</a>
                    </li>
                  </ul>
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
                  <img src="images/WARP_LOGO.svg" alt=""><?php echo $_SESSION['email-login'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <!-- top tiles -->
        <div class="row tile_count">

          <?php
          // Make a query to get the total registered shelter accounts by COUNTing all the user with role id == 2
          $sql = "SELECT COUNT(user_id) AS totalshelter FROM user_tbl WHERE role_id = '2'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalshelter = $row['totalshelter'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Registered Shelter Accounts</span>
            <div class="count green"><?= $totalshelter ?></div>
          </div>

          <?php
          // Make a query to get the total registered adopter accounts by COUNTing all the user with role id == 1
          $sql = "SELECT COUNT(user_id) AS totaladopter FROM user_tbl WHERE role_id = '1'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totaladopter = $row['totaladopter'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Registered Adopter Accounts</span>
            <div class="count green"><?= $totaladopter ?></div>
          </div>

          <?php
          // Make a query to get the total pet adoptee listed by counting all the pet_id
          $sql = "SELECT COUNT(pet_id) AS totalpetadoptee FROM adoptee_tbl WHERE deleted_at IS NULL";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalpetadoptee = $row['totalpetadoptee'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Pet Adoptee Listed</span>
            <div class="count green"><?= $totalpetadoptee ?></div>
          </div>

          <?php
          // Make a query to get the total pet adopted by COUNTing all the user with role id == 1
          $sql = "SELECT COUNT(adopted_id) AS totaladoptedpet FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totaladoptedpet = $row['totaladoptedpet'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Pet Adopted</span>
            <div class="count green"><?= $totaladoptedpet ?></div>
          </div>
        </div>
        <!-- /top tiles -->

      </div>
    </div>
    <!-- /page content -->
    <!-- footer content -->
    <footer>
      <div class="pull-right">
        <!-- Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a> -->
        Copyright &copy; 2023 All rights reserved | UI design by <a href="https://colorlib.com/">Colorlib</a> &#x2764;, Modified by WARP Team
      </div>
    <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

  </div>
  </div>



  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="../vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="../vendors/Flot/jquery.flot.js"></script>
  <script src="../vendors/Flot/jquery.flot.pie.js"></script>
  <script src="../vendors/Flot/jquery.flot.time.js"></script>
  <script src="../vendors/Flot/jquery.flot.stack.js"></script>
  <script src="../vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="../vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>

</body>

</html>