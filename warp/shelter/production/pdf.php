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
// Query to check if user_id from the login sesh = shelteruser_id to get the city 
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
if ($result->num_rows != 1) {
  die('id not found');
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
  <title>Animal Shelter | Adoptee Pet Information</title>

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
  <!-- Dropzone.js -->
  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet"> <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/warp/shelter/production/css/style.css">

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="logo">
            <a href="../../home.php">
              <img src="/Capstone/warp/img/logo.png" alt="">
            </a>
          </div>
          <div class="clearfix"></div>


          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="/Capstone/warp/WARP Admin/production/images/<?= $row['city_img']; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>
                <?php
                echo $row['shelteruser_name'] . ',';
                ?>
                <br>
                <?php
                echo $row['shelteruser_position'];
                ?>
              </h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />


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

                      <form method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="">


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">First Name: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['adopter_fname']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Last Name: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['adopter_lname']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Age: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['adopter_age']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Home Address: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['adopter_city']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Contact Number: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['adopter_cnum']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-age">E-mail Address: </span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['user_email']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q1']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Civil Status: </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q2']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are there children (below 18) in the house? If yes how old are they? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q3']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Do you have other children? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q4']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Have you had pets in the past? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q5']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who else do you live with? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q6']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are any members of your household allergic to animals? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q7']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be responsible for feeding, grooming, and generally caring for your pet? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q8']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be financially responsible for your pet's needs? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q9']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will look after your pet if you go on vacation or in case of emergency? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q10']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">How many hours in an average workday will your pet be left alone? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q11']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Does everyone in the family support your decision to adopt a pet? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q12']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">What type of building do you live in? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q13']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">If you rent, do you have permission from your landlord to have an animal? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q14']; ?></p>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are you prepared to spend for the wellness of your pet? If so, how much are you willing to spend in a year? </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12"><?php echo $row['q15']; ?></p>
                          </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Dropzone.js -->
    <script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>
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

</body>

</html>