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

// Kukunin yung answers from application form na equivalent sa questionchoices
$id = $_GET['id'];
$sql = "SELECT * FROM applicationform1 WHERE application_id = $id";
$result = $conn->query($sql);
$qdata = mysqli_fetch_assoc($result);

if ($result->num_rows != 1) {
  die('id not found');
}

if ($result->num_rows > 0) {
  $adopter_id = $qdata['adopter_id'];
  // Kukunin yung adopter info na ishoshow sa view form
  $sql = "SELECT * FROM adopter_tbl INNER JOIN user_tbl ON adopter_tbl.user_id = user_tbl.user_id WHERE adopter_id = '$adopter_id'";
  $result = $conn->query($sql);
  if ($result == TRUE) {
    $adata = mysqli_fetch_assoc($result);
  }

  if ($result->num_rows != 1) {
    die('id not found');
  }
}
// Pag naclick si cancel button, mapapalitan yung application status sa application list
if (isset($_POST['cancel'])) {
  $id = $_GET['id'];
  $cancel = 'Cancelled by adopter';
  $sql = "UPDATE applicationresult_tbl SET application_status='$cancel' WHERE application_id = '$id'";
  $result = $conn->query($sql);
  if ($result == TRUE) {
    header('Location: adopter_user_page.php');
  }

  // $sql_city = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
  // $result_city = mysqli_query($conn, $sql);

  // //Kukunin si city_id para maidentify kung saang city lang lalabas yung notif
  // if($result_city->num_rows > 0){
  //   $city = mysqli_fetch_assoc($result_city);
  //   $city_id = $city['city_id'];
    //function sa cancelled by adopter na notif
    $msg = 'This adopter has cancelled their application form for pet'; //Eto yung message sa notif tas concat yung name ng pet sa dulo
    $sql_insert = mysqli_query($conn, "INSERT INTO shelternotif_tbl(application_id, message) VALUES('$id', '$msg')"); //Di ko alam pano ipapasok yung city_id para ma specify kung saang shelter lang dapat lalabas yung notif, may WHERE pa dapat
    if($sql_insert){
      echo"<script>alert('Successfully cancelled adoption')</script>";
    }else{
      echo mysqli_error($conn);
      exit;
    }

  // }
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
  <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="/Capstone/warp/img/WARP_LOGO copy.png">
  <title>Adopter | My Application | </title>

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
              <h2><?php echo $adata['adopter_fname']; ?></h2>
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
              <!-- Notification bell -->
              
              <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>

                  
              </nav>
            </div>
          </div>
          
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Edit Adoptee</h3>
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
                  <!-- <h2>Form Design <small>different form elements</small></h2> -->

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />

                  <form method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Adopter I.D: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="images/valid_id/<?= $qdata['valid_id']; ?>" alt="Adopter Identification Card" height="150" width="150">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">First Name: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['adopter_fname'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Last Name: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['adopter_lname'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Age: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['adopter_age'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Home Address: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['adopter_city'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Contact Number: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['adopter_cnum'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-age">E-mail Address: </span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="" value="<?= $adata['user_email'] ?>" class="form-control col-md-7 col-xs-12" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q1'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Civil Status: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q2'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are there children (below 18) in the house? If yes how old are they? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q3'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Do you have other children? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q4'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Have you had pets in the past? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q5'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who else do you live with? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q6'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are any members of your household allergic to animals? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q7'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be responsible for feeding, grooming, and generally caring for your pet? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q8'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be financially responsible for your pet's needs? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q9'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will look after your pet if you go on vacation or in case of emergency? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q10'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">How many hours in an average workday will your pet be left alone? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q11'] ?>. hour/s" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Does everyone in the family support your decision to adopt a pet? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q12'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">What type of building do you live in? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q13'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">If you rent, do you have permission from your landlord to have an animal? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q14'] ?>" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are you prepared to spend for the wellness of your pet? If so, how much are you willing to spend in a year? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q15'] ?>" disabled>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button name="cancel" class="btn btn-round btn-danger" onclick="return confirm('Are you sure you want to cacncel this application?');">Cancel Application</button>
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</body>

</html>