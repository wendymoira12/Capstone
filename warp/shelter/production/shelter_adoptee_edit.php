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

$id = $_GET['id'];
$sql3 = "SELECT * FROM adoptee_tbl WHERE pet_id = $id";
$result3 = $conn->query($sql3);

if ($result3->num_rows != 1) {
  die('id not found');
}

$data = mysqli_fetch_assoc($result3);
$chkvalues = explode(", ", $data["pet_vax"]);

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
  $sql2 = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result2 = mysqli_query($conn, $sql2);
  if ($result2 == TRUE) {
    $row2 = mysqli_fetch_assoc($result2);
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
  <link rel="shortcut icon" type="image/x-icon" href="/img/WARP_LOGO copy.png">
  <title><?php echo $row2['city_name']; ?> | Adoptee Pet Information</title>

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
  <link rel="stylesheet" href="/warp/shelter/production/css/style.css">
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
                  <img src="/shelter/production/images/logo/<?= $row2['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="/logout.php?logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/home.php">Go to Homepage </i></a>
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

                  <form enctype="multipart/form-data" action="modify.php?id=<?= $id ?>" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="pet-name" value="<?= $data['pet_name'] ?>" required class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-age">Age <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="pet-age" value="<?= $data['pet_age'] ?>" required class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Color <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="color" value="<?= $data['pet_color'] ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Breed <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="breed" value="<?= $data['pet_breed'] ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Specie <span class="required">*</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="specie" value="Dog" <?php echo ($data['pet_specie'] == "Dog") ? "checked" : "" ?> required> &nbsp; Dog &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="specie" value="Cat" <?php echo ($data['pet_specie'] == "Cat") ? "checked" : "" ?> required> &nbsp; Cat &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender <span class="required">*</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="gender" value="Male" <?php echo ($data['pet_gender'] == "Male") ? "checked" : "" ?> required> &nbsp; Male &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="gender" value="Female" <?php echo ($data['pet_gender'] == "Female") ? "checked" : "" ?> required> &nbsp; Female &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Neutered/Spayed <span class="required">*</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                          <input type="radio" name="neuter" value="Yes" <?php echo ($data['pet_neuter'] == "Yes") ? "checked" : "" ?> required> &nbsp; Yes &nbsp;
                          </label>

                          <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" > -->
                          <input type="radio" name="neuter" value="No" <?php echo ($data['pet_neuter'] == "No") ? "checked" : "" ?> required> &nbsp; No &nbsp;
                          </label>
                        </div>
                      </div>
                    </div>

                    <?php
                    if (in_array("5in1", $chkvalues)) {
                      $chkvalue1 = "checked='checked'";
                    }
                    if (in_array("4in1", $chkvalues)) {
                      $chkvalue2 = "checked='checked'";
                    }
                    if (in_array("Anti-Rabies", $chkvalues)) {
                      $chkvalue3 = "checked='checked'";
                    }
                    if (in_array("Not Applicable", $chkvalues)) {
                      $chkvalue4 = "checked='checked'";
                    }
                    ?>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Vaccine <span class="required">*</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="checkbox" name="vaccine[]" id="cb1" value="5in1" <?php echo $chkvalue1; ?> data-parsley-mincheck="1" required /> 5in1

                        <input type="checkbox" name="vaccine[]" id="cb2" value="4in1" <?php echo $chkvalue2; ?> data-parsley-mincheck="1" required /> 4in1

                        <input type="checkbox" name="vaccine[]" id="cb3" value="Anti-Rabies" <?php echo $chkvalue3; ?> data-parsley-mincheck="1" required /> Anti-Rabies

                        <input type="checkbox" name="vaccine[]" id="cb4" value="Not Applicable" <?php echo $chkvalue4; ?> data-parsley-mincheck="1" required /> Not Applicable
                      </div>
                    </div>

                    <!-------- NOT APPLICABLE CHECKBOX CHECK AND UNCHECK OTHER CHECKBOXES --------->

                    <script>
                      var cb1 = document.getElementById("cb1");
                      var cb2 = document.getElementById("cb2");
                      var cb3 = document.getElementById("cb3");
                      var cb4 = document.getElementById("cb4");

                      cb4.addEventListener('change', () => {
                        console.log("checkbox clicked")
                        if (cb4.checked == true) {
                          cb1.disabled = true;
                          cb2.disabled = true;
                          cb3.disabled = true;

                          cb1.checked = false;
                          cb2.checked = false;
                          cb3.checked = false;


                        } else {
                          cb1.disabled = false;
                          cb2.disabled = false;
                          cb3.disabled = false;

                        }
                      })
                    </script>

                    <div class="form-group">
                      <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Weight(kg) <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="weight" value="<?= $data['pet_weight'] ?>" required>
                      </div>
                    </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">This pet has been <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="origin" class="select2_single form-control" tabindex="-1" required>

                            <option value="Rescued" <?php echo ($data['pet_origin'] == "Rescued") ? "selected" : "" ?>>Rescued</option>
                            <option value="Surrendered" <?php echo ($data['pet_origin'] == "Surrendered") ? "selected" : "" ?>>Surrendered</option>
                            <option value="Stray Captured" <?php echo ($data['pet_origin'] == "Stray Captured") ? "selected" : "" ?>>Stray Captured</option>

                          </select>
                        </div>
                      </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Size <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="size" class="select2_single form-control" tabindex="-1" required>

                          <option value="Small" <?php echo ($data['pet_size'] == "Small") ? "selected" : "" ?>>Small</option>

                          <option value="Average" <?php echo ($data['pet_size'] == "Average") ? "selected" : "" ?>>Average</option>

                          <option value="Large" <?php echo ($data['pet_size'] == "Large") ? "selected" : "" ?>>Large</option>

                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="pet-medrec" class="control-label col-md-3 col-sm-3 col-xs-12">Medical Record <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" name="medrec" value="<?= $data['pet_medrec'] ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Sociability <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="sociability" class="select2_single form-control" tabindex="-1" required>

                          <option value="1" <?php echo ($data['pet_lsoc'] == "1") ? "selected" : "" ?>>Very Poor</option>

                          <option value="2" <?php echo ($data['pet_lsoc'] == "2") ? "selected" : "" ?>>Poor</option>

                          <option value="3" <?php echo ($data['pet_lsoc'] == "3") ? "selected" : "" ?>>Okay</option>

                          <option value="4" <?php echo ($data['pet_lsoc'] == "4") ? "selected" : "" ?>>Good</option>

                          <option value="5" <?php echo ($data['pet_lsoc'] == "5") ? "selected" : "" ?>>Superb</option>

                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Energy <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="energy" class="select2_single form-control" tabindex="-1" required>

                          <option value="1" <?php echo ($data['pet_lene'] == "1") ? "selected" : "" ?>>Very Poor</option>

                          <option value="2" <?php echo ($data['pet_lene'] == "2") ? "selected" : "" ?>>Poor</option>

                          <option value="3" <?php echo ($data['pet_lene'] == "3") ? "selected" : "" ?>>Okay</option>

                          <option value="4" <?php echo ($data['pet_lene'] == "4") ? "selected" : "" ?>>Good</option>

                          <option value="5" <?php echo ($data['pet_lene'] == "5") ? "selected" : "" ?>>Superb</option>

                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Affection <span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="affection" class="select2_single form-control" tabindex="-1" required>

                          <option value="1" <?php echo ($data['pet_laff'] == "1") ? "selected" : "" ?>>Very Poor</option>

                          <option value="2" <?php echo ($data['pet_laff'] == "2") ? "selected" : "" ?>>Poor</option>

                          <option value="3" <?php echo ($data['pet_laff'] == "3") ? "selected" : "" ?>>Okay</option>

                          <option value="4" <?php echo ($data['pet_laff'] == "4") ? "selected" : "" ?>>Good</option>

                          <option value="5" <?php echo ($data['pet_laff'] == "5") ? "selected" : "" ?>>Superb</option>

                        </select>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea name="description" class="form-control col-md-7 col-xs-12" required> <?= $data['pet_desc'] ?> </textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="pet-img" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Image<span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="file" accept="" name="pet-img1" value="<?= $data['pet_img1'] ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="pet-img" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Image<span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="file" name="pet-img2" value="<?= $data['pet_img2'] ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="pet-vid" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Video<span class="required">*</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="file" name="pet-vid" value="<?= $data['pet_vid'] ?>" required>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="shelter_adoptee_list.php">
                          <button name="pet-cancel" class="btn btn-round btn-primary" type="button" onclick="return confirm('Are you sure you want to cancel editing adoptee info?');">Back</button>
                        </a>
                        <button name="pet-reset" class="btn btn-round btn-danger" type="reset" onclick="return confirm('Are you sure you want to reset all info?');">Reset</button>

                        <button name="edit-pet-submit" class="btn btn-round btn-success" onclick="return confirm('Are you sure you want to submit all changes?');">Submit</button>
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