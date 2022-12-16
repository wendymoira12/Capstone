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

if (isset($_POST['confirm'])) {

  $fed = $_POST['fed'];
  $health = $_POST['health'];
  $space = $_POST['space'];
  $clean = $_POST['clean'];
  $accustomed = $_POST['accustomed'];
  $remark = $_POST['remark'];
  $done = "Monitored";
  $monitor_name = $_POST['monitor_name'];

  if (!empty($fed) && !empty($health) && !empty($space) && !empty($clean) && !empty($accustomed) && !empty($remark)) {
    //Check if adopted pet data exist if true proceed
    $sql = "SELECT adopted_id FROM adopted_tbl WHERE adopted_id = '$adopted_id'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
      //Insert into adoptedpetstatus_tbl if adopted data exist
      $sql3 = "INSERT INTO adoptedpetstatus_tbl(q1_fed, q2_health, q3_space, q4_clean, q5_accustomed, petstatus_remark, monitoredby_name ,adopted_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql3)) {
        echo "SQL Prepared Statement Failed";
      } else {
        mysqli_stmt_bind_param($stmt, "sssssssi", $fed, $health, $space, $clean, $accustomed, $remark, $monitor_name, $adopted_id);
        mysqli_stmt_execute($stmt);
        $sql4 = "UPDATE adopted_tbl SET monitoring_status = ? WHERE adopted_id = ?";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql4)) {
          echo "SQL Prepared Statement Failed";
        } else {
          mysqli_stmt_bind_param($stmt2, "si", $done, $adopted_id);
          mysqli_stmt_execute($stmt2);
          echo "<script>alert('Change Monitoring Status Success')</script>";
          echo "<script>window.location.href='shelter_adopted_list.php';</script>";
        }
      }
    } else {
      echo "<script>alert('Record doesn't exist')</script>";
    }
  } else {
    echo "<script>alert('Empty Fields')</script>";
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
                          <input type="radio" name="fed" value="Yes" required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="fed" value="No" required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet healthy? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="health" value="Yes" required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="health" value="No" required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet has sufficient space in the house? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="space" value="Yes" required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="space" value="No" required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the space is clean and well kept? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="clean" value="Yes" required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="clean" value="No" required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Is the pet well accustomed to the place? <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="accustomed" value="Yes" required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="accustomed" value="No" required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comment/Remark <span class="required">*</span>
                      </label>
                      <div class="col-md-5 col-sm-6 col-xs-12">
                        <textarea id="textarea" required="required" name="remark" class="form-control col-md-7 col-xs-12"></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monitor_name">Evaluated/Monitored by: <span class="required">*</span>
                      </label>
                      <div class="col-md-5 col-sm-6 col-xs-12">
                        <input type="text" name="monitor_name" required class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button name="radio-reset" class="btn btn-round  btn-primary" type="reset">Reset</button>
                        <button name="confirm" class="btn btn-round btn-success" type="submit">Confirm</button>
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