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
  <title>Animal Adoption Application Form</title>

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





<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h2><?php echo $row['city_name'] . " " . "Animal Shelter" ?></h2>
        <h3>Agreement Form</h3>
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




            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name"></label>
              <div class="col-md-6 col-sm-6 col-xs-12">

                </br>
                </br>
                <?php

                date_default_timezone_set('Asia/Manila');
                $dateform = date("F j, Y");
                $sqlform = "SELECT applicationform1.adopter_address, schedule_tbl.schedule_id, schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adopter_tbl.adopter_cnum, adoptee_tbl.pet_name, adoptee_tbl.pet_specie,adoptee_tbl.pet_breed, adoptee_tbl.pet_color,adoptee_tbl.pet_gender, schedule_tbl.application_id, adopter_tbl.adopter_id FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id ='$city_id' AND schedule_tbl.deleted_at IS NULL";

                $resultform = mysqli_query($conn, $sqlform);

                if ($resultform->num_rows > 0) {
                  $rowform = mysqli_fetch_assoc($resultform);
                }

                ?>
                <h5>Pet Details</h5>
                <p><b>Specie: </b> <?= $rowform['pet_specie'] ?> <b>Name: </b> <?= $rowform['pet_name'] ?> <b>Breed: </b> <?= $rowform['pet_breed'] ?> <b>Sex: </b> <?= $rowform['pet_gender'] ?> <b>Color: </b> <?= $rowform['pet_color'] ?> </p>



                I, <?= $rowform['adopter_fname'] . " " . $rowform['adopter_lname'] ?>, referred to as the adopter henceforth, hereby accept that the aforementioned animal is only being adopted by me as a pet for myself and/or my close family. I certify that I will not, under any circumstances, sell, give away, auction, institute, or otherwise dispose of said animal to any person(s), dealer, store, or other organization. I agree to first get in touch with the aforementioned animal shelter and provide them the choice to recover the pet at no cost if, at a later time, I am unable or unable to retain it.
                </br>
                </br>
                I hereby commit to caring for the aforementioned pet in a humane and responsible manner and to giving it a clean and suitable home, food, water, and medical attention. I additionally concur that the aforementioned pet must live within my house and is not permitted to roam freely.
                </p>
                <br>

                <p> <b>Adopter's name:</b> <?= $rowform['adopter_fname'] . " " . $rowform['adopter_lname'] ?></p>
                <p> <b>Address:</b> <?= $rowform['adopter_address'] ?></p>
                <p> <b>Phone Number:</b> <?= $rowform['adopter_cnum'] ?></p>
                <br>
                <p> I confirm that the information on this adoption agreement is accurate and true to the best of my knowledge. I accept that the Animal Shelter has the right to take the aforementioned pet away if any of my claims turn out to be untrue.
                </p>
                <br>
                <br>
                <br>
                <p> ____________________________________ </p>
                <p><b> Adopter's Signature </b></p>
                </br>
                <p> ____________________________________ </p>
                <p><b> Shelter Official's Signature </b></p>
                </br>
                <p> </p>

                <p><b> Date: </b><?= $dateform ?> </p>
                <br>
              </div>
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
<?php

$city_id = $row['city_id'];
$sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
$result = mysqli_query($conn, $sql);
if ($result == TRUE) {
  $row = mysqli_fetch_assoc($result);
}
$city = $row['city_img'];

// $data = file_get_contents("/Capstone/warp/shelter/production/images/logo/$row[city_img]");
// $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

?>

<style>
  @page {
    margin: 0.5in;
  }

  .form-control {
    border-radius: 0;
    width: 100%;
    position: relative;
    min-height: 1px;
    float: left;
    padding-right: 10px;
    padding-left: 10px;
  }

  .form-control {
    display: block;
    width: 100%;
    height: 22px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }

  label {
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
  }

  body {
    font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.471;
    margin: 0.25in;
    /* background-image: url("Capstone/warp/shelter/production/images/logo/$row[city_img]");
        background-repeat: no-repeat;
        background-attachment: fixed;  
        background-size: cover; */

  }
</style>

</body>

</html>