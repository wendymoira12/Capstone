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

<?php
if (isset($_POST['submit_reset'])) {
  unset($_SESSION['start_date'], $_SESSION['end_date'], $_SESSION['monitor_start_date'], $_SESSION['monitor_end_date'], $_SESSION['monitor_status']);
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
  <title><?php echo $row2['city_name']; ?> | Adopted Pet List</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>List of Adopted Pets </h3>
              <br>
            </div>
          </div>
          <div class="x_content">
            <div class="col-md-10 col-sm-12 col-xs-12">
              <!-- DATA FILTER -->
              <form method="post" action="">

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">
                    <input type="date" name="start_date" class="form-control">
                    <p class="text-muted">&nbsp; Start Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">

                    <input type="date" name="end_date" class="form-control">
                    <p class="text-muted">&nbsp; End Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_date" class="btn btn-success">Filter</button>
                    <a href="report_shelter_adopted_list.php"><button name="submit_reset" class="btn btn-danger" type="submit">Reset</button></a>
                    <a href="report_adopted_list_pdf.php" target="_blank"><button name="viewPDF" class="btn btn-primary" type="button">View as PDF</button></a>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="x_content">
            <div class="col-md-10 col-sm-12 col-xs-12">
              <!-- DATA FILTER -->
              <form method="post" action="">

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">
                    <input type="date" name="monitor_start_date" class="form-control">
                    <p class="text-muted">&nbsp; Monitoring Start Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">

                    <input type="date" name="monitor_end_date" class="form-control">
                    <p class="text-muted">&nbsp; Monitoring End Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-md-1 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_monitor_date" class="btn btn-success">Filter</button>
                  </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select name="monitor_status" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Not Yet">Not Yet</option>
                      <option value="Monitored">Monitored</option>
                    </select>
                    <p class="text-muted">&nbsp; Monitoring Status</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_monitor_status" class="btn btn-success">Filter</button>
                  </div>
                </div>
              </form>
            </div>
          </div>




          <div class="clearfix"></div>
          <div class="row">
            <br>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_content">
                  <!-- PRIMARY TABLE - SHOWS ALL DATA -->
                  <?php
                  if (isset($_POST['submit_date'])) {

                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    $_SESSION['start_date'] = $_POST['start_date'];
                    $_SESSION['end_date'] = $_POST['end_date'];

                    $i = 1;
                    $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE (adopted_tbl.date_adopted BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
                    $result1 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result1) > 0) {
                      $total = mysqli_num_rows($result1);
                  ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>Pet Name</th>
                            <th>Date Adopted</th>
                            <th>Monitoring Date</th>
                            <th>Monitoring Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result1 as $data1) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data1['adopter_fname'] . ' ' . $data1['adopter_lname']; ?></td>
                              <td><?= $data1['pet_name']; ?></td>
                              <td><?= $data1['date_adopted']; ?></td>
                              <td><?= $data1['monitoring_date']; ?></td>
                              <td><?= $data1['monitoring_status']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {

                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH MONITORING DATE FILTER
                  else if (isset($_POST['submit_monitor_date'])) {
                    $monitor_start_date = $_POST['monitor_start_date'];
                    $monitor_end_date = $_POST['monitor_end_date'];

                    $_SESSION['monitor_start_date'] = $_POST['monitor_start_date'];
                    $_SESSION['monitor_end_date'] = $_POST['monitor_end_date'];

                    $i = 1;
                    $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE (adopted_tbl.monitoring_date BETWEEN '$monitor_start_date' and '$monitor_end_date') AND adoptee_tbl.city_id = '$city_id'";
                    $result2 = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result2) > 0) {
                      $total = mysqli_num_rows($result2);
                    ?>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>Pet Name</th>
                            <th>Date Adopted</th>
                            <th>Monitoring Date</th>
                            <th>Monitoring Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($result2 as $data2) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data2['adopter_fname'] . ' ' . $data2['adopter_lname']; ?></td>
                              <td><?= $data2['pet_name']; ?></td>
                              <td><?= $data2['date_adopted']; ?></td>
                              <td><?= $data2['monitoring_date']; ?></td>
                              <td><?= $data2['monitoring_status']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH MONITORING STATUS FILTER
                  else if (isset($_POST['submit_monitor_status'])) {
                    $monitor_status = $_POST['monitor_status'];
                    $_SESSION['monitor_status'] = $_POST['monitor_status'];
                    $i = 1;
                    $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adopted_tbl.monitoring_status = '$monitor_status' AND adoptee_tbl.city_id = '$city_id'";
                    $result3 = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result3) > 0) {
                      $total = mysqli_num_rows($result3);
                    ?>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>Pet Name</th>
                            <th>Date Adopted</th>
                            <th>Monitoring Date</th>
                            <th>Monitoring Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($result3 as $data3) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data3['adopter_fname'] . ' ' . $data3['adopter_lname']; ?></td>
                              <td><?= $data3['pet_name']; ?></td>
                              <td><?= $data3['date_adopted']; ?></td>
                              <td><?= $data3['monitoring_date']; ?></td>
                              <td><?= $data3['monitoring_status']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }
                  // SHOWS DATA WITH NO FILTER
                  else {
                    ?>
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Adopter Name</th>
                          <th>Pet Name</th>
                          <th>Date Adopted</th>
                          <th>Monitoring Date</th>
                          <th>Monitoring Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id'";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                          foreach ($result as $data) {
                        ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data['adopter_fname'] . ' ' . $data['adopter_lname']; ?></td>
                              <td><?= $data['pet_name']; ?></td>
                              <td><?= $data['date_adopted']; ?></td>
                              <td><?= $data['monitoring_date']; ?></td>
                              <td><?= $data['monitoring_status']; ?></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                    <!-- PRIMARY TABLE - SHOWS ALL DATA -->

                  <?php } ?>
                </div>
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
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
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