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

// Kukunin yung answers from application form na equivalent sa questionchoices
$id = $_GET['id'];
$sql = "SELECT * FROM applicationform1 WHERE application_id = '$id'";
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
  <link href="../build/css/custom1.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="css/imagepopup.css"> -->



  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php
      include "sidebar.php";
      ?>

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
                  <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="/Capstone/warp/logout.php?logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
                <!-- NOTIF START -->
                <?php
                include "shelter_notif.php";
                ?>
                <!-- NOTIF END -->

          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
            
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

                  <form method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name"></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      <h1> Agreement Form </h1>
                        </br>
                        </br>
                        <?php 

                        date_default_timezone_set('Asia/Manila');
                        $dateform = date('Y-m-d');
                        $sqlform = "SELECT applicationform1.adopter_address, schedule_tbl.schedule_id, schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adopter_tbl.adopter_cnum, adoptee_tbl.pet_name, adoptee_tbl.pet_specie,adoptee_tbl.pet_breed, adoptee_tbl.pet_color,adoptee_tbl.pet_gender, schedule_tbl.application_id, adopter_tbl.adopter_id FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id ='$city_id' AND schedule_tbl.deleted_at IS NULL";

                        $resultform = mysqli_query($conn, $sqlform);
                    
                        if ($resultform->num_rows > 0) {
                            $rowform = mysqli_fetch_assoc($resultform);

                    }
                      
                            ?>
                        <h5>Pet Details</h5>
                        <p><b>Specie: </b> <?= $rowform['pet_specie']?> &nbsp &nbsp <b>Name: </b> <?= $rowform['pet_name']?>  &nbsp &nbsp  <b>Breed: </b> <?= $rowform['pet_breed']?> &nbsp &nbsp <b>Sex: </b> <?= $rowform['pet_gender'] ?> &nbsp &nbsp <b>Color: </b> <?= $rowform['pet_color']?>    </p>

                            
                            
                            I, <?= $rowform['adopter_fname'] ." ". $rowform['adopter_lname']?>, referred to as the adopter henceforth, hereby accept that the aforementioned animal is only being adopted by me as a pet for myself and/or my close family. I certify that I will not, under any circumstances, sell, give away, auction, institute, or otherwise dispose of said animal to any person(s), dealer, store, or other organization. I agree to first get in touch with the aforementioned animal shelter and provide them the choice to recover the pet at no cost if, at a later time, I am unable or unable to retain it.
                            </br>
                            </br>
                            I hereby commit to caring for the aforementioned pet in a humane and responsible manner and to giving it a clean and suitable home, food, water, and medical attention. I additionally concur that the aforementioned pet must live within my house and is not permitted to roam freely.
                            </p>
                        <br>

                        <p> <b>Adopter's name:</b> <?= $rowform['adopter_fname'] ." ". $rowform['adopter_lname'] ?></p>
                        <p> <b>Address:</b> <?= $rowform['adopter_address']?></p>
                        <p> <b>Phone Number:</b> <?= $rowform['adopter_cnum']?></p>
                        <br>
                        <p> 
                          I confirm that the information on this adoption agreement is accurate and true to the best of my knowledge. I accept that the Animal Shelter has the right to take the aforementioned pet away if any of my claims turn out to be untrue.
                        </p>
                        <br>
                        <br>
                        <br>
                        <p>  ____________________________________ </p>
                        <p><b>  &nbsp &nbsp &nbsp Adopter's Signature </b></p>
                        </br>
                        <p>  ____________________________________ </p>
                        <p><b>  &nbsp &nbsp &nbsp Shelter Official's Signature </b></p>
                        </br>
                        <p>   </p>
                        
                        <p><b>  &nbsp &nbsp Date: </b><?= $dateform ?> </p>
                        <br>
                      </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="shelter_application_list.php">
                          <button class="btn btn-round btn-primary" type="button" onclick="return confirm('Are you sure you want to go back?');">Back</button>
                        </a> 

                        <a href="agreementform_pdf.php?id=<?= htmlspecialchars($id) ?>">
                          <button class="btn btn-round btn-primary" type="button">View as PDF</button>
                        </a>

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
  <script>
    var modal = document.getElementById("myModal");
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    img.onclick = function() {
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
      modal.style.display = "none";
    }
  </script>


</body>

</html>