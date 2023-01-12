<?php

include 'config.php';

// Kukunin yung adopter info na ishoshow sa view form
$sql = "SELECT * FROM adopter_tbl INNER JOIN user_tbl ON adopter_tbl.user_id = user_tbl.user_id WHERE adopter_id";
$result = $conn->query($sql);
if ($result == TRUE) {
  $adata = mysqli_fetch_assoc($result);
}

$sql = "SELECT * FROM applicationform1 WHERE application_id";
$result = $conn->query($sql);
$qdata = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="/img/WARP_LOGO copy.png">
  <title>Animal Application Form</title>

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


</head>


<!-- page content -->

<h1>WARP APPLICATION FORM</h1>
<form method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="report_generation.php">
  <div class="form-group">

    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">First Name: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="adopter_fname" value="<?= $adata['adopter_fname'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Last Name: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="adopter_lname" value="<?= $adata['adopter_lname'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Age: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="adopter_age" value="<?= $adata['adopter_age'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Home Address: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="adopter_city" value="<?= $adata['adopter_city'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Contact Number: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="adopter_cnum" value="<?= $adata['adopter_cnum'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-age">E-mail Address: </span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" name="user_email" value="<?= $adata['user_email'] ?>" class="form-control col-md-7 col-xs-12" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q1" value="<?= $qdata['q1'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Civil Status: </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q2" value="<?= $qdata['q2'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are there children (below 18) in the house? If yes how old are they? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q3" value="<?= $qdata['q3'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Do you have other children? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q4" value="<?= $qdata['q4'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Have you had pets in the past? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q5" value="<?= $qdata['q5'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who else do you live with? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q6" value="<?= $qdata['q6'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are any members of your household allergic to animals? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q7" value="<?= $qdata['q7'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be responsible for feeding, grooming, and generally caring for your pet? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q8" value="<?= $qdata['q8'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be financially responsible for your pet's needs? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q9" value="<?= $qdata['q9'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Who will look after your pet if you go on vacation or in case of emergency? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q10" value="<?= $qdata['q10'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">How many hours in an average workday will your pet be left alone? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q11" value="<?= $qdata['q11'] ?>. hour/s" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Does everyone in the family support your decision to adopt a pet? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q12" value="<?= $qdata['q12'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">What type of building do you live in? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q13" value="<?= $qdata['q13'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">If you rent, do you have permission from your landlord to have an animal? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q14" value="<?= $qdata['q14'] ?>" disabled>
    </div>
  </div>

  <div class="form-group">
    <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Are you prepared to spend for the wellness of your pet? If so, how much are you willing to spend in a year? </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" type="text" name="q15" value="<?= $qdata['q15'] ?>" disabled>
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

  <style>
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
    }
  </style>


  </body>

</html>