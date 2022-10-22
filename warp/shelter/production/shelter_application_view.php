<?php
error_reporting(0);

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

if (!isset($_GET['id'])) {
  die('Id not provided');
}

// Kukunin yung answers from application form na equivalent sa questionchoices
$id = $_GET['id'];
// $sql = "SELECT * FROM applicationform1 INNER JOIN questionchoices ON applicationform1.q1 = questionchoices.id, applicationform1.q2 = questionchoices.id, applicationform1.q3 = questionchoices.id, applicationform1.q4 = questionchoices.id, applicationform1.q5 = questionchoices.id, applicationform1.q6 = questionchoices.id, applicationform1.q7 = questionchoices.id, applicationform1.q8 = questionchoices.id, applicationform1.q9 = questionchoices.id, applicationform1.q10 = questionchoices.id, applicationform1.q11 = questionchoices.id, applicationform1.q12 = questionchoices.id, applicationform1.q13 = questionchoices.id, applicationform1.q14 = questionchoices.id, applicationform1.q15 = questionchoices.id WHERE application_id = $id";

$sql = "SELECT * FROM applicationform1 WHERE application_id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
  die('id not found');
}

$qdata = mysqli_fetch_assoc($result);

// Kukunin yung adopter info na ishoshow sa view form
$sql = "SELECT * FROM adopter_tbl INNER JOIN user_tbl ON adopter_tbl.user_id = user_tbl.user_id WHERE adopter_id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
  die('id not found');
}

$adata = mysqli_fetch_assoc($result);

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

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="#"><i class="fa fa-home"></i> Account </a>
                </li>
                <li><a href="#"><i class="fa fa-edit"></i> Add Adoptee info </a>
                </li>
                <li><a href="#"><i class="fa fa-paw"></i> Pet Adoptee List </a>
                </li>
                <li><a href="#"><i class="fa fa-paw"></i> Application List </a>
                </li>
                <li><a href="#"><i class="fa fa-paw"></i> Adopted Pet List </a>
                </li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

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
                  <img src="/Capstone/warp/WARP Admin/production/images/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>

          </nav>
        </div>
      </div>
      <!-- /top navigation -->

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

                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Adopter I.D: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="shelter/production/images/valid_id/<?= $data['valid_id']; ?>" alt="Adopter Identification Card">
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
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q1']= '1'){
                        echo 'Student';
                      }else if($qdata['q1']= '2'){
                        echo 'Employed';
                      }else if($qdata['q1']= '3'){
                        echo 'Self-Employed';
                      }else if($qdata['q1']= '4'){
                        echo 'None';
                      }
                      ?>" disabled>
                        </div>
                      </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Civil Status: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q2']= '5'){
                        echo 'Single';
                      }else if($qdata['q2']= '6'){
                        echo 'Married';
                      }else if($qdata['q2']= '7'){
                        echo 'Other';
                      }
                      ?>" disabled>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are there children (below 18) in the house? If yes how old are they? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q3']= '8'){
                        echo 'There are children below 8 years old.';
                      }else if($qdata['q3']= '9'){
                        echo 'All children in our house are older than 8 years old';
                      }else if($qdata['q3']= '10'){
                        echo 'There are no children living in our house';
                      }
                      ?>" disabled>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Do you have other children? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q4']= '11'){
                        echo 'Yes';
                      }else if($qdata['q4']= '12'){
                        echo 'None';
                      }
                      ?>" disabled>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Have you had pets in the past? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q5']= '13'){
                        echo 'Yes';
                      }else if($qdata['q5']= '14'){
                        echo 'No';
                      }
                      ?>" disabled>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who else do you live with? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q6']= '15'){
                        echo 'I live by myself';
                      }else if($qdata['q6']= '16'){
                        echo 'Spouse/Partner';
                      }else if($qdata['q6']= '17'){
                        echo 'Parents';
                      }else if($qdata['q6']= '18'){
                        echo 'Roommate/s';
                      }else if($qdata['q6']= '19'){
                        echo 'Other Relatives';
                      }
                      ?>" disabled>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are any members of your household allergic to animals? </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?php
                      if($qdata['q7']= '20'){
                        echo 'Yes';
                      }else if($qdata['q7']= '21'){
                        echo 'No';
                      }else if($qdata['q7']= '22'){
                        echo 'I don\'t know';
                      }
                      ?>" disabled>
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
                        <input class="form-control col-md-7 col-xs-12" type="text" name="" value="<?= $qdata['q11'] ?>" disabled>
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
                        <a href="shelter_application_list.php">
                          <button name="pet-cancel" class="btn btn-round btn-primary" type="button">Cancel</button>
                        </a>
                        <button name="pet-reset" class="btn btn-round btn-danger" type="reset">Reject</button>
                        <a href="#" data-toggle="modal" data-target="#modalDate"><button name="edit-pet-submit" class="btn btn-round btn-success">Accept</button></a>
                      </div>

                      
                      <div class="modal fade" id="modalDate">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              Schedule a date for interview
                            </div>
                            <div class="modal-body">
                              <input type="date">
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-success">Submit
                              </button>
                            </div>
                          </div> 
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