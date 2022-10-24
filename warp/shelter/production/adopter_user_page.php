<?php
include 'config.php';
session_start();

//if hindi nakaset si user-email and user-role-id babalik sya sa login.php

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'],$_SESSION['user_id'])) {
  header('Location:/Capstone/warp/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 1) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/Capstone/warp/home.php');
  }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM adopter_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $adopter_id = $row['adopter_id'];
  $sql = "SELECT * FROM user_tbl INNER JOIN adopter_tbl ON user_tbl.user_id = adopter_tbl.user_id WHERE user_tbl.user_id AND adopter_tbl.user_id ='$adopter_id'";
  $result = mysqli_query($conn, $sql);
  if ($result == TRUE) {
    $adopterresult = mysqli_fetch_assoc($result);
  }
}
?>

<?php
$sqlapp= "SELECT * FROM applicationform1, applicationresult_details WHERE adopter_id ='$adopter_id';";

$result = mysqli_query($conn, $sqlapp);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
      $row1 = mysqli_fetch_assoc($result);
    } else {
        echo 'not found';
    }
} else {
    echo 'Error: ' . mysqli_error();
}

//mysqli_close($mysqli);

?>
<?php

$sql = "SELECT pet_name FROM adoptee_tbl, applicationform1 WHERE adoptee_tbl.pet_id = applicationform1.pet_id;";
$result = $conn->query($sql);
$data = mysqli_fetch_assoc($result);


?>
<?php


//mysqli_close($mysqli);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="/Capstone/warp/img/WARP_LOGO copy.png">
  <title>Adopter | My Applications</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Capstone/warp/shelter/production/css/style.css">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="logo">
            <a href="">
              <img src="images/logo.png" alt="">
            </a>
          </div>
          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/img2.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $row['adopter_fname']; ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Adopter</h3>
              <ul class="nav side-menu">
                <li><a href="adopter_user_page.php"><i class="fa fa-folder-open"></i> My Applications </a>
                </li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->

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
                    
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                      <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                  </li>
                  <li><a href="logout.php?logout">Logout </i></a>
                  <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
                  
              </nav>
            </div>
          </div>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>My Application List</h3>
            </div>



            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Basic Tables <small>basic table subtitle</small></h2> -->

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Application ID</th>
                          <th>Pet Name</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <th scope="row"><?php echo $row1['application_id']; ?></th>
                          <th scope="row"><?php echo $data['pet_name']; ?></th>
                          <td><?php echo $row1['date_submitted']; ?></td>
                          <td><?php echo $row1['application_status']; ?></td>
                          <td><input type="button" value="cancel" class="btn btn-round btn-danger"></button></td>
                        </tr>
                      </tbody>
                    </table>

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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</body>

</html>