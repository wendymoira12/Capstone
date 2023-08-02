<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['email-login'])) {
  header('Location: login.php');
}
?>
<?php
// Form submit for shelter update
if (isset($_POST['submit-update'])) {

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr  = 'Email is required';
  } else {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // Validate Name
  if (empty($_POST['name'])) {
    $nameErr = 'Full Name is required';
  } else {
    $name = filter_input(
      INPUT_POST,
      'name',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate Position
  if (empty($_POST['position'])) {
    $positionErr = 'Position is required';
  } else {
    $position = filter_input(
      INPUT_POST,
      'position',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }
  // Store in variables other data to be updated

  $user_id = $_SESSION['user_id'];
  $shelteruser_id = $_SESSION['shelteruser_id'];

  //If there are no errors the function will execute
  if (empty($emailErr) && empty($nameErr) && empty($positionErr)) {
    // Query to update the shelter_tbl first
    $sql = "UPDATE shelteruser_tbl SET shelteruser_name = ?, shelteruser_position = ? WHERE shelteruser_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL Prepare Statement Failed";
    } else {
      mysqli_stmt_bind_param($stmt, "ssi", $name, $position, $shelteruser_id);
      mysqli_stmt_execute($stmt);
      $sql2 = "UPDATE user_tbl SET user_email = ? WHERE user_id = ?";
      $stmt2 = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        echo "SQL Prepare Statement Failed";
      } else {
        mysqli_stmt_bind_param($stmt2, "si", $email, $user_id);
        mysqli_stmt_execute($stmt2);
        header('location:manage_shelter.php');
      }
    }
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

  <title>Edit Shelter </title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-wysiwyg -->
  <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <!-- Switchery -->
  <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
  <!-- starrr -->
  <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

</head>

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
                  header("Location:login.php");
                }
                ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->


          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="admin_home.php"><i class="fa fa-home"></i> Home <span></span></a></li>
                <li><a href="manage_city.php"><i class="fa fa-building-o"></i> Manage Cities <span></span></a></li>
                <li><a><i class="fa fa-users"></i> Manage Accounts <span class="fa fa-chevron-down"></span></a>
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
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Manage Shelter</h3><br>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Shelter Account</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php
                    //Check if naget ung id sa URL
                    if (isset($_GET['id'])) {
                      //istotore sa $shelteruser_id ung id na nakuha sa url parameter
                      $id = $_GET['id'];
                      //Kukunin ung info ng both tables kung saan ung shelter_tbl.id = $shelteruser_id
                      $sql = "SELECT shelteruser_tbl.shelteruser_id, shelteruser_tbl.shelteruser_name, shelteruser_tbl.shelteruser_position,
                       user_tbl.user_email, user_tbl.user_id FROM user_tbl INNER JOIN shelteruser_tbl ON user_tbl.user_id = shelteruser_tbl.user_id WHERE shelteruser_tbl.shelteruser_id='$id'";
                      $result = mysqli_query($conn, $sql);
                      //If successful ung query ilalagay sa array ung data
                      if ($result->num_rows > 0) {
                        $row = mysqli_fetch_assoc($result);
                        foreach ($result as $rows) {
                          $_SESSION['rows'] = $rows;
                          $_SESSION['user_id'] = $rows['user_id'];
                          $_SESSION['shelteruser_id'] = $rows['shelteruser_id'];
                    ?>
                          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Address <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" class="form-control col-md-7 col-xs-12 <?php echo !$emailErr ?:
                                                                                            'is-invalid'; ?>" required="required" type="email" name="email" value="<?= $row['user_email']; ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">Full Name<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $row['shelteruser_name']; ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="position" name="position" required="required" class="form-control col-md-7 col-xs-12" value="<?= $row['shelteruser_position']; ?>">
                              </div>
                            </div>
                      <?php
                        }
                      } else {
                        echo 'Error' . mysqli_error($conn);
                      }
                    }
                      ?>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit-update">Submit</button>
                          <a href="manage_shelter.php" class="btn btn-danger" name="cancel-update">Cancel</a>
                        </div>
                      </div>
                          </form>
                  </div>
                </div>
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
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
  <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
  <script src="../vendors/google-code-prettify/src/prettify.js"></script>
  <!-- jQuery Tags Input -->
  <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
  <!-- Switchery -->
  <script src="../vendors/switchery/dist/switchery.min.js"></script>
  <!-- Select2 -->
  <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
  <!-- Parsley -->
  <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
  <!-- Autosize -->
  <script src="../vendors/autosize/dist/autosize.min.js"></script>
  <!-- jQuery autocomplete -->
  <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
  <!-- starrr -->
  <script src="../vendors/starrr/dist/starrr.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
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

</body>
</html>