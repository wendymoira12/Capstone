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

if (!isset($_GET['id'])) {
  die('Id not provided');
} else {
  $adopter_id = $_GET['id'];
}

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

  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom1.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/warp/shelter/production/css/style.css">

</head>

<body class="nav-md">
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
              <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="changepass.php"><i class="fa fa-wrench pull-right"></i>Change Password</a></li>
              <li><a href="/Capstone/warp/logout.php?logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
            </ul>
          </li>
          <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
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


    <?php
    $sql = "SELECT adopter_fname, adopter_lname, adopter_cnum, adopter_currentadd, adopter_permanentadd FROM adopter_tbl WHERE adopter_id = '$adopter_id'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
      $data = mysqli_fetch_assoc($result);
    } else {
      echo "Adopter doesn't exist";
    }

    ?>
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Adopter Information</h3>
          <br>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">

              <div class="title_left">
                <h3><i class="fa fa-user">&nbsp;</i><?= $data['adopter_fname'] . ' ' . $data['adopter_lname']; ?></h3>
              </div>
              <div class="title_right">
              </div>
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
              <div class="x_content">
                <div class="clearfix"></div>
                <h2><i class="fa fa-home">&nbsp;</i>Current Address</h2>
                <p><?= $data['adopter_currentadd']; ?></p>
                <br>
                <h2><i class="fa fa-home">&nbsp;</i>Permanent Address</h2>
                <p><?= $data['adopter_permanentadd']; ?></p>
                <br>
                <h2><i class="fa fa-phone">&nbsp;</i>Contact No.</h2>
                <p><?= $data['adopter_cnum']; ?></p>
                <br>
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>City</th>
                      <th>Date</th>
                      <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $sql = "SELECT city_tbl.city_name, applicationform1.date_submitted, applicationresult_tbl.application_status FROM applicationform1 INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE applicationform1.adopter_id = '$adopter_id'";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows > 0) {
                      foreach ($result as $rows) {
                    ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $rows['city_name']; ?></td>
                          <td><?= $rows['date_submitted']; ?></td>
                          <td><?= $rows['application_status']; ?></td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
                <a href="javascript:history.go(-1)">
                  <button type="button" class="btn btn-round btn-danger">Go back</button>
                </a>
              </div>
            </div>
          </div>


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

  <!-- Datatables -->
  <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../vendors/jszip/dist/jszip.min.js"></script>
  <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
</body>

</html>