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
  <link rel="shortcut icon" type="image/x-icon" href="/warp/img/WARP_LOGO copy.png">
  <title>Animal Shelter | Adopted Pet List</title>

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
  <?php
  include "sidebar.php";
  ?>
  <!-- /top navigation -->

  <!-- page content -->

  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>List of Adopted Pets </h3>
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
              <h4>This table shows all the pet that has been adopted. </h4>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Adopter Name</th>
                    <th>Pet Image 1</th>
                    <th>Pet Image 2</th>
                    <th>Pet Name</th>
                    <th>Date Adopted</th>
                    <th>Monitoring Date</th>
                    <th>Monitoring Status</th>
                    <th>Action</th>
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
                        <td><?= '<img src="images/pet_img1/' . $data['pet_img1'] . '" alt="pet" width="100">'; ?></td>
                        <td><?= '<img src="images/pet_img2/' . $data['pet_img2'] . '" alt="pet" width="100">'; ?></td>
                        <td><?= $data['pet_name']; ?></td>
                        <td><?= $data['date_adopted']; ?></td>
                        <td><?= $data['monitoring_date']; ?></td>
                        <td><?= $data['monitoring_status']; ?></td>
                        <td>
                          <a href="shelter_adopted_list2.php?id=<?= $data['adopted_id'] ?>">
                            <button type="submit" class="btn btn-round btn-primary">Edit Date</button>
                          </a>
                          <a href="edit_monitoring_status.php?adopted_id=<?= $data['adopted_id'] ?>">
                            <button type="submit" class="btn btn-round btn-success">Pet Monitored</button>
                          </a>
                          <a href="view_adopter.php?id=<?= $data['adopter_id']; ?>">
                            <button type="button" class="btn btn-round btn-info">Show Adopter Info</button>
                          </a>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
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