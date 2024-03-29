<?php
session_start();
include 'config.php';
include('export.php');


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

<?php
if (isset($_POST['submit_reset'])) {
  unset($_SESSION['start_date'], $_SESSION['end_date'], $_SESSION['result'], $_SESSION['status']);
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

  <title> <?php echo $row['city_name']; ?> | Application List</title>
  <link rel="shortcut icon" type="image/x-icon" href="/warp/img/WARP_LOGO copy.png">
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

  <!-- JS Datatable --->
  <script src="js/datepickers.js"></script>

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
                  <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
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
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>List of Applications</h3>
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

                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_date" class="btn btn-success">Filter</button>
                    <a href="report_shelter_application_list.php"><button name="submit_reset" class="btn btn-danger" type="submit">Reset</button></a>
                    <a href="report_application_list_pdf.php" target="_blank"><button name="viewPDF" class="btn btn-primary" type="button">View as PDF</button></a>
                    <button type="submit" name="export" class="btn btn-warning" formaction="export_application_list.php">Export as CSV</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="x_content">
            <div class="col-md-10 col-sm-12 col-xs-12">
              <form action="" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select name="result" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Not Qualified">Not Qualified</option>
                      <option value="Qualified">Qualified</option>
                    </select>
                    <p class="text-muted">&nbsp; System Assessment</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_result" class="btn btn-success">Filter</button>
                  </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select name="status" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Pending">Pending</option>
                      <option value="Scheduled">Scheduled</option>
                      <option value="Cancelled by adopter">Cancelled by adopter</option>
                      <option value="Rejected">Rejected</option>
                      <option value="Finished">Finished</option>
                    </select>
                    <p class="text-muted">&nbsp; Application Status</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_status" class="btn btn-success">Filter</button>
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

                <!-- PRIMARY TABLE - SHOWS ALL DATA -->
                <div class="x_content">
                  <?php

                  if (isset($_POST['submit_date'])) {

                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    $_SESSION['start_date'] = $_POST['start_date'];
                    $_SESSION['end_date'] = $_POST['end_date'];

                    $i = 1;
                    $sql = "SELECT applicationform1.adopter_id, applicationform1.pet_id, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, adopter_tbl.adopter_fname, applicationresult_tbl.application_id, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, adoptee_tbl.city_id, applicationresult_tbl.acceptedby_name FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE (applicationform1.date_submitted BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
                    $result1 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result1) > 0) {
                      $total = mysqli_num_rows($result1);
                  ?>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter</th>
                            <th>Adoptee</th>
                            <th>Date Submitted</th>
                            <th>System Assessment</th>
                            <th>Application Status</th>
                            <th>Accepted By</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($result1 as $data1) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data1['adopter_fname'] . ' ' . $data1['adopter_lname']; ?></td>
                              <td><?= $data1['pet_name']; ?></td>
                              <td><?= $data1['date_submitted']; ?></td>
                              <td><?= $data1['application_result']; ?></td>
                              <td><?= $data1['application_status']; ?></td>
                              <td><?= $data1['acceptedby_name']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH SYSTEM ASSESSMENT FILTER
                  else if (isset($_POST['submit_result'])) {
                    $appli_result = $_POST['result'];
                    $_SESSION['result'] = $_POST['result'];
                    $i = 1;
                    $sql = "SELECT applicationform1.adopter_id, applicationform1.pet_id, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, adopter_tbl.adopter_fname, applicationresult_tbl.application_id, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, adoptee_tbl.city_id, applicationresult_tbl.acceptedby_name FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id' AND applicationresult_tbl.application_result = '$appli_result'";
                    $result2 = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result2) > 0) {
                      $total = mysqli_num_rows($result2);
                    ?>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter</th>
                            <th>Adoptee</th>
                            <th>Date Submitted</th>
                            <th>System Assessment</th>
                            <th>Application Status</th>
                            <th>Accepted By</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($result2 as $data2) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data2['adopter_fname'] . ' ' . $data2['adopter_lname']; ?></td>
                              <td><?= $data2['pet_name']; ?></td>
                              <td><?= $data2['date_submitted']; ?></td>
                              <td><?= $data2['application_result']; ?></td>
                              <td><?= $data2['application_status']; ?></td>
                              <td><?= $data2['acceptedby_name']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH STATUS FILTERED
                  else if (isset($_POST['submit_status'])) {
                    $appli_status = $_POST['status'];
                    $_SESSION['status'] = $_POST['status'];
                    $i = 1;
                    $sql = "SELECT applicationform1.adopter_id, applicationform1.pet_id, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, adopter_tbl.adopter_fname, applicationresult_tbl.application_id, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, adoptee_tbl.city_id, applicationresult_tbl.acceptedby_name FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id' AND applicationresult_tbl.application_status = '$appli_status'";
                    $result3 = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result3) > 0) {
                      $total = mysqli_num_rows($result3);
                    ?>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Adopter</th>
                            <th>Adoptee</th>
                            <th>Date Submitted</th>
                            <th>System Assessment</th>
                            <th>Application Status</th>
                            <th>Accepted By</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($result3 as $data3) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data3['adopter_fname'] . ' ' . $data3['adopter_lname']; ?></td>
                              <td><?= $data3['pet_name']; ?></td>
                              <td><?= $data3['date_submitted']; ?></td>
                              <td><?= $data3['application_result']; ?></td>
                              <td><?= $data3['application_status']; ?></td>
                              <td><?= $data3['acceptedby_name']; ?></td>
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
                          <th>Adopter</th>
                          <th>Adoptee</th>
                          <th>Date Submitted</th>
                          <th>System Assessment</th>
                          <th>Application Status</th>
                          <th>Accepted By</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT applicationform1.adopter_id, applicationresult_tbl.acceptedby_name, applicationform1.pet_id, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, adopter_tbl.adopter_fname, applicationresult_tbl.application_id, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, adoptee_tbl.city_id FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id'";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                          foreach ($result as $data) {
                        ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data['adopter_fname'] . ' ' . $data['adopter_lname']; ?></td>
                              <td><?= $data['pet_name']; ?></td>
                              <td><?= $data['date_submitted']; ?></td>
                              <td><?= $data['application_result']; ?></td>
                              <td><?= $data['application_status']; ?></td>
                              <td><?= $data['acceptedby_name']; ?></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  <?php
                  }
                  ?>
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
  <!-- <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#datatable').DataTable();

      $('#datatable tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        alert('You clicked on ' + data[0] + "'s row");
      });
    });
  </script> -->
</body>

</html>