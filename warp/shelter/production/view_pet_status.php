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
  $sql2 = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result2 = mysqli_query($conn, $sql2);
  if ($result2 == TRUE) {
    $row2 = mysqli_fetch_assoc($result2);
  }
}
?>

<?php

if (!isset($_GET['adopted_id'])) {
  header('Location:shelter_adopted_list.php');
} else {
  $adopted_id = $_GET['adopted_id'];
}

$sql3 = "SELECT * FROM adoptedpetstatus_tbl WHERE adopted_id = '$adopted_id'";
$result3 = mysqli_query($conn, $sql3);
if ($result3->num_rows > 0) {
  $qdata = mysqli_fetch_assoc($result3);
} else {
  echo "<script>alert('Record doesnt Exist!')</script>";
  header('Location:shelter_adopted_list.php');
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
  <title><?php echo $row2['city_name']; ?> | Pet Status</title>

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
      <!-- /top navigation -->


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
      <!-- page content -->

      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Adopted Pet Status Evaluation</h3>
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
                  <h4>Pet Status</h4>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form action="" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet fed regularly? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="fed" value="Yes" <?php if ($qdata['q1_fed'] == "Yes"){ echo "checked"; }?> disabled> &nbsp; Yes &nbsp;


                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="fed" value="No" <?php if ($qdata['q1_fed'] == "No"){ echo "checked"; }?> disabled> &nbsp; No &nbsp;

                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet healthy? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="health" value="Yes" <?php if ($qdata['q2_health'] == "Yes"){ echo "checked"; }?> disabled> &nbsp; Yes &nbsp;


                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="health" value="No" <?php if ($qdata['q2_health'] == "No"){ echo "checked"; }?> disabled> &nbsp; No &nbsp;

                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet has sufficient space in the house? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="space" value="Yes" <?php if ($qdata['q3_space'] == "Yes"){ echo "checked"; }?> disabled> &nbsp; Yes &nbsp;


                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="space" value="No" <?php if ($qdata['q3_space'] == "No"){ echo "checked"; }?> disabled> &nbsp; No &nbsp;

                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the space is clean and well kept? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="clean" value="Yes" <?php if ($qdata['q4_clean'] == "Yes"){ echo "checked"; }?> disabled> &nbsp; Yes &nbsp;


                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="clean" value="No" <?php if ($qdata['q4_clean'] == "No"){ echo "checked"; }?> disabled> &nbsp; No &nbsp;

                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet well accustomed to the place? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="accustomed" value="Yes" <?php if ($qdata['q5_accustomed'] == "Yes"){ echo "checked"; }?> disabled> &nbsp; Yes &nbsp;


                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="accustomed" value="No" <?php if ($qdata['q5_accustomed'] == "No"){ echo "checked"; }?> disabled> &nbsp; No &nbsp;

                        </div>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comment/Remark <span class="required">*</span>
                      </label>
                      <div class="col-md-5 col-sm-6 col-xs-12">
                        <textarea id="textarea" required="required" name="remark" class="form-control col-md-7 col-xs-12" disabled><?= $qdata['petstatus_remark']?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monitor_name">Evaluated/Monitored by: <span class="required">*</span>
                      </label>
                      <div class="col-md-5 col-sm-6 col-xs-12">
                        <input type="text" name="monitor_name"  class="form-control col-md-7 col-xs-12" value="<?= $qdata['monitoredby_name']?>" disabled>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="javascript:history.go(-1)">
                          <button name="go-back" class="btn btn-round btn-danger" type="button">Go Back</button>
                        </a>
                      </div>
                    </div>
                  </form>
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