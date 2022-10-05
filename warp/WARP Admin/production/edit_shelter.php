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

  // Validate City
  if (empty($_POST['city'])) {
    $cityErr = 'City is required';
  } else {
    $city = filter_input(
      INPUT_POST,
      'city',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate Contact
  if (empty($_POST['contact'])) {
    $contactErr = 'contact is required';
  } else {
    $contact = filter_input(
      INPUT_POST,
      'contact',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }
  // Store in variables other data to be updated
  $user_id = $_SESSION['user_id'];
  $shelter_id = $_SESSION['shelter_id'];
  $about = $_POST['about'];
  $position = $_POST['position'];

  //If there are no errors the function will execute
  if (empty($emailErr) && empty($cityErr) && empty($contactErr)) {
    // Query to update the shelter_tbl first
    $sql = "UPDATE shelter_tbl SET shelter_city='$city', shelter_contact='$contact', shelter_about='$about', shelter_position='$position' WHERE shelter_id='$shelter_id'";
    // If true then the query will be executed and another query will be executed
    if (mysqli_query($conn, $sql) === TRUE) {
      $sql = "UPDATE user_tbl SET user_email='$email' WHERE user_id='$user_id'";
      // If true the query will be executed and will be redirected back to manage_shelter.php
      if (mysqli_query($conn, $sql)) {
        header('location:manage_shelter.php');
      } else {
        echo "Error" . mysqli_error($conn);
      }
    } else {
      echo "Error" . mysqli_error($conn);
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
  <link rel="shortcut icon" type="image/x-icon" href="/warp/img/WARP_LOGO copy.png">

  <title>Manage Accounts </title>

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
                  header("Location: login.php");
                }
                ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="admin_home.php"><i class="fa fa-home"></i> Home <span></span></a>
                </li>
                <li><a><i class="fa fa-users"></i> Manage Accounts <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="manage_shelter.php">Shelter</a></li>
                    <li><a href="manage_adopter.php">Adopter</a></li>
                  </ul>
                </li>
              </ul>
            </div>


          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
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
                      //istotore sa $shelter_id ung id na nakuha sa url parameter
                      $id = $_GET['id'];
                      //Kukunin ung info ng both tables kung saan ung shelter_tbl.id = $shelter_id
                      $sql = "SELECT shelter_tbl.shelter_id, shelter_tbl.shelter_city, shelter_tbl.shelter_contact, shelter_tbl.shelter_about, shelter_tbl.shelter_position,
                       user_tbl.user_email, user_tbl.user_id FROM user_tbl INNER JOIN shelter_tbl ON user_tbl.user_id = shelter_tbl.user_id WHERE shelter_tbl.shelter_id='$id'";
                      $result = mysqli_query($conn, $sql);
                      //If successful ung query ilalagay sa array ung data
                      if ($result->num_rows > 0) {
                        $row = mysqli_fetch_assoc($result);
                        foreach ($result as $rows) {
                          $_SESSION['rows'] = $rows;
                          $_SESSION['user_id'] = $rows['user_id'];
                          $_SESSION['shelter_id'] = $rows['shelter_id'];

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="city" name="city" required="required" class="form-control col-md-7 col-xs-12 <?php echo !$cityErr ?: 'is-invalid'; ?>" value="<?= $row['shelter_city']; ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Contact Number<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="contact" name="contact" required="required" class="form-control col-md-7 col-xs-12 <?php echo !$contactErr ?: 'is-invalid'; ?>" value="<?= $row['shelter_contact']; ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">About/Bio<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="about" name="about" class="form-control col-md-7 col-xs-12" value="<?= $row['shelter_about']; ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="position">Position<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="position" name="position" required="required" class="form-control col-md-7 col-xs-12" value="<?= $row['shelter_position']; ?>">
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

      <!-- footer content -->
      <footer>
        <!-- <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
      </div> -->
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