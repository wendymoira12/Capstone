<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['email-login'])) {
  header('Location: login.php');
}
?>

<?php
// Form submit for shelter creation
if (isset($_POST['submit'])) {

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr  = 'Email is required';
  } else {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // Validate password
  if (empty($_POST['password'])) {
    $passErr = 'Password is required';
  } else {
    $pass = filter_input(
      INPUT_POST,
      'password',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate confirm password
  if (empty($_POST['cpassword'])) {
    $cpassErr = 'Password is required';
  } else {
    $cpass = filter_input(
      INPUT_POST,
      'cpassword',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($emailErr) && empty($passErr) && empty($cpassErr)) {
    //Check if password == to confirm password
    if ($pass == $cpass) {
      //To check if username exists in the database
      $sql = "SELECT * FROM user_tbl WHERE user_email= ?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL Prepare Statement Failed";
      } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        // If the query is false, add data to database
        if (!$result->num_rows > 0) {
          $pass = password_hash($pass, PASSWORD_DEFAULT);
          $role = 2;
          $sql2 = "INSERT INTO user_tbl (user_email, user_password, role_id) VALUES (?, ?, ?)";
          $stmt2 = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt2, $sql2)) {
            echo "SQL Prepare Statement Failed";
          } else {
            mysqli_stmt_bind_param($stmt2, "ssi", $email, $pass, $role);
            mysqli_stmt_execute($stmt2);
            // success
            $_SESSION['role_id'] = $role;
            $_SESSION['user_email'] = $email;
            header('Location: manage_shelter_2.php');
          }
        } else {
          echo "<script>alert('Oops! Email already used')</script>";
        }
      }
    } else {
      echo "<script>alert('Password doesnt Match')</script>";
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
                <li><a href="admin_home.php"><i class="fa fa-home"></i> Home <span></span></a></li>
                <li><a href="manage_city.php"><i class="fa fa-building-o"></i> Manage Cities </a></li>
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
                    <h2>Create Shelter Account</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="email" class="form-control col-md-7 col-xs-12 <?php echo !$emailErr ?: 'is-invalid'; ?>" required="required" type="email" name="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12 <?php echo !$passErr ?: 'is-invalid'; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">Confirm Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="cpassword" name="cpassword" required="required" class="form-control col-md-7 col-xs-12 <?php echo !$cpassErr ?: 'is-invalid'; ?>">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Next</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>List of Shelter Accounts<small>Users</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Full Name</th>
                      <th>Position</th>
                      <th>City</th>
                      <th>City Contact Number</th>
                      <th>E-mail Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $sql = "SELECT shelteruser_tbl.shelteruser_name, shelteruser_tbl.shelteruser_position, shelteruser_tbl.shelteruser_id, city_tbl.city_name, city_tbl.city_contact, user_tbl.user_email FROM shelteruser_tbl INNER JOIN city_tbl ON shelteruser_tbl.city_id = city_tbl.city_id INNER JOIN user_tbl ON shelteruser_tbl.user_id = user_tbl.user_id WHERE shelteruser_tbl.deleted_at IS NULL";
                    $result = mysqli_query($conn, $sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                      foreach ($result as $row) {
                    ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= $row['shelteruser_name']; ?></td>
                          <td><?= $row['shelteruser_position']; ?></td>
                          <td><?= $row['city_name']; ?></td>
                          <td><?= $row['city_contact']; ?></td>
                          <td><?= $row['user_email']; ?></td>
                          <td>
                            <a href="edit_shelter.php?id=<?= $row['shelteruser_id'] ?>" type="submit" class="btn btn-round btn-success">Update</a>
                            <a href="delete_shelteruser.php?shelteruser_id=<?= $row['shelteruser_id'] ?>"><button type="button" class="btn btn-round btn-danger" onclick="return confirm('Are you sure you want to delete this data?');"> Delete</button></a>
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