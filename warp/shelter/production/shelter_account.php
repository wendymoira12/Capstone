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
// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $city_id = $row['city_id'];
  $sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result2 = mysqli_query($conn, $sql);
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

  <title><?php echo $row2['city_name']; ?> | Account</title>

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
      <?php
      include "sidebar.php";
      ?>

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
                  <li><a href="/changepass.php"><i class="fa fa-wrench pull-right"></i>Change Password</a></li>
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

        <div class="row tile_count">
          <?php
          // Make a query to get the total registered adoptees by COUNTing all the adoptees with city id == which shelter city id
          $sql = "SELECT COUNT(pet_id) AS currentadoptee FROM adoptee_tbl WHERE city_id = '$city_id' AND deleted_at IS NULL";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $data = mysqli_fetch_assoc($result);
            $currentadoptee = $data['currentadoptee'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-paw"></i> No. of Current Pet Adoptee Listed</span>
            <div class="count"><?= $currentadoptee ?></div>
          </div>

          <?php
          // Make a query to get the total registered adoptees by COUNTing all the adoptees with city id == which shelter city id
          $sql = "SELECT COUNT(applicationresult_id) AS currentapplications FROM applicationresult_tbl INNER JOIN applicationform1 ON applicationresult_tbl.application_id  = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id' AND applicationresult_tbl.application_status != 'Finished' AND applicationresult_tbl.application_status != 'Cancelled by adopter'";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $data = mysqli_fetch_assoc($result);
            $currentapplications = $data['currentapplications'];
          }
          ?>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-file-text"></i> Ongoing Applications </span>
            <div class="count"><?= $currentapplications ?></div>
          </div>

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
            <span class="count_top"><i class="fa fa-paw"></i> Total Pet Adoptee Listed</span>
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
            <span class="count_top"><i class="fa fa-file-text"></i> Total Received Applications</span>
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
                  <?php echo '<img src="images/logo/' . $row2['city_img'] . '" alt="shelter logo"'; ?>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12" style="border:0px solid #e5e5e5;">
              <h3 class="x_title"><?php echo $row2['city_name']; ?> </h3>
              <div class="clearfix"></div>
              <h2><strong>About us</strong></h2>
              <p><?php echo $row2['city_about']; ?></p>
              <br>
              <h2><strong>Contact us</strong></h2>
              <p><?php echo $row2['city_contact']; ?></p>
              <br>
              <h2><strong>Email Address</strong></h2>
              <p> <?php echo $row2['city_email']; ?> </p>
              <br>
              <a href="shelter_account_edit.php?city_id=<?php $city_id ?>">
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