<?php

include 'config.php';
session_start();

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
  header('Location:/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 2) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/home.php');
  }
}

if (isset($_POST['pet-submit'])) {

  $pet_name = $_POST['pet-name'];
  $pet_age = $_POST['pet-age'];
  $color = $_POST['color'];
  $breed = $_POST['breed'];
  $specie = $_POST['specie'];
  $gender = $_POST['gender'];
  $neuter = $_POST['neuter'];
  $origin = $_POST['origin'];
  $vaccine = $_POST['vaccine'];
  // to print multiple vaccines if multiple vaccines are checked
  $chkstr = implode(", ", $vaccine);

  $weight = $_POST['weight'];
  $size = $_POST['size'];
  $medrec = $_POST['medrec'];
  $sociability = $_POST['sociability'];
  $energy = $_POST['energy'];
  $affection = $_POST['affection'];
  $description = $_POST['description'];

  $pet_img1 = $_FILES['pet-img1']['name'];
  $pet_img_tmp_name = $_FILES['pet-img1']['tmp_name'];
  // upload image to folder named images/
  $pet_img_folder = '/images/pet_img1/' . $pet_img1;
  // only images can be uploaded
  //$pet_img_imagetype = exif_imagetype($pet_img_tmp_name);
  //if (!$pet_img_imagetype) {
  //echo ('Uploaded file is not an image.');
  //}

  $pet_img2 = $_FILES['pet-img2']['name'];
  $pet_img_tmp_name1 = $_FILES['pet-img2']['tmp_name'];
  // upload image to folder named images/
  $pet_img_folder1 = '/images/pet_img2/' . $pet_img2;
  // only images can be uploaded
  //$pet_img_imagetype1 = exif_imagetype($pet_img_tmp_name1);
  //if (!$pet_img_imagetype1) {
  // echo ('Uploaded file is not an image.');
  //}

  //Check pet_img size
  // if ($_FILES["pet_img1"]["size"] > 5000000000) {
  //   echo "Your file is too large, must be less than 5mb";
  // }

  //Check pet_img1 size
  // if ($_FILES["pet_img2"]["size"] > 5000000000) {
  //   echo "Your file is too large, must be less than 5mb";
  // }

  //extension nung file dapat JPEG PNG GIF XBM XPM WBMP WebP BMP
  //$image_extension1 = image_type_to_extension($pet_img_imagetype, true);
  //$image_extension2 = image_type_to_extension($pet_img_imagetype1, true);

  //converts image name into hexadecimal
  //$image_name1 = bin2hex(random_bytes(16)) . $image_extension1;
  //$image_name2 = bin2hex(random_bytes(16)) . $image_extension2;

  $pet_vid = $_FILES['pet-vid']['name'];
  $pet_vid_tmp_name = $_FILES['pet-vid']['tmp_name'];
  // upload video to folder named images/
  $pet_vid_folder = '/images/pet_vid/' . $pet_vid;

  //Check pet_vid size
  // if($_FILES["pet_vid"]["size"] > 30000000000){
  //   echo "Your file is too large, must be less than 30mb";
  // }

  if (empty($pet_img1) && empty($pet_img2) && ($pet_vid) && empty($pet_name) && empty($pet_age) && empty($color) && empty($breed) && empty($specie) && empty($gender) && empty($neuter) && empty($origin) &&  empty($chkstr) && empty($weight) && empty($size) && empty($medrec) && empty($sociability) && empty($energy) && empty($affection) && empty($description)) {
    $message[] = 'Please fill ouT all fieldS';
  } else {
    $user_id = $_SESSION['user_id'];

    // Query to check if user_id from the login sesh == user id in the shelter table
    // If true get the shelter ID and insert into adoptee table as foreign key
    $sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
    $result = mysqli_query($conn, $sql);
    // If true get shelter id from the shelter table to be inserted in adoptee table
    if ($result->num_rows > 0) {
      $row = mysqli_fetch_assoc($result);
      $city_id = $row['city_id'];
      $sql3 = "INSERT INTO adoptee_tbl(pet_img1, pet_img2, pet_vid, pet_name, pet_age, pet_color, pet_breed, pet_specie, pet_gender, pet_neuter, pet_origin, pet_vax, pet_weight, pet_size, pet_medrec, pet_lsoc, pet_lene, pet_laff, pet_desc, city_id) VALUES('$pet_img1', '$pet_img2', '$pet_vid', '$pet_name', '$pet_age', '$color', '$breed', '$specie', '$gender', '$neuter', '$origin', '$chkstr', '$weight', '$size', '$medrec', '$sociability', '$energy', '$affection', '$description', '$city_id')";

      $result3 = mysqli_query($conn, $sql3);

      // UPLOAD THE IMAGES AND VIDEOS IN THE IMAGES FOLDER
      if ($result3 == TRUE) {
        move_uploaded_file($pet_img_tmp_name, __DIR__ . $pet_img_folder);
        move_uploaded_file($pet_img_tmp_name1, __DIR__ . $pet_img_folder1);
        move_uploaded_file($pet_vid_tmp_name, __DIR__ . $pet_vid_folder);

        echo "<script>alert('Adoptee added successfully')</script>";
        echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
      } else {
        echo "<script>alert('Oops! Something went wrong')</script>";
        echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
      }
    } else {
      echo "<script>alert('Oops! Something went wrong')</script>";
    }
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
  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <script type="text/javascript">
  </script>

  <!-- Custom Theme Style -->
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
      <div class="right_col scroll-view" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Add an Adoptee</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">
                  <br />

                  <!---------------------- TINANGGAL KO MUNA YUNG DROPZONE ---------------------->

                  <!-- <div class="clearfix"></div>

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h3>Add Adoptee Images and Videos</h3>
                                
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <p>Drag multiple files to the box below for multi upload or click to select files. This is for demonstration purposes only, the files are not uploaded to any server.</p>
                                <form action="shelter_adoptee_info.php" class="dropzone"></form>
                                <br />
                                <br />
                                <br />
                                <br /> 
                              </div>
                            </div>
                          </div>
                        </div> -->
                  <div class="overflow-auto">
                    <form enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="pet-name" required class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pet-age">Age <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="pet-age" required class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Color <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="color" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="color" class="control-label col-md-3 col-sm-3 col-xs-12">Breed <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="breed" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Specie <span class="required">*</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="btn-group" data-toggle="buttons">
                            <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="specie" value="Dog" required> &nbsp; Dog &nbsp;
                            </label>

                            <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="specie" value="Cat" required> &nbsp; Cat &nbsp;
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender <span class="required">*</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="btn-group" data-toggle="buttons">
                            <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="gender" value="Male" required> &nbsp; Male &nbsp;
                            </label>

                            <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="gender" value="Female" required> &nbsp; Female &nbsp;
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Neuter <span class="required">*</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="btn-group" data-toggle="buttons">
                            <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="neuter" value="Yes" required> &nbsp; Yes &nbsp;
                            </label>

                            <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" > -->
                            <input type="radio" name="neuter" value="No" required> &nbsp; No &nbsp;
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">This pet has been<span class="required">*</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="btn-group" data-toggle="buttons">
                            <!-- <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default"> -->
                            <input type="radio" name="origin" value="Rescued" required> &nbsp; Rescued &nbsp;
                            </label>

                            <!-- <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" > -->
                            <input type="radio" name="origin" value="Surrendered" required> &nbsp; Surrendered &nbsp;
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Vaccine <span class="required">*</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" name="vaccine[]" id="cb1" value="5in1" data-parsley-mincheck="1" required /> 5in1

                          <input type="checkbox" name="vaccine[]" id="cb2" value="4in1" data-parsley-mincheck="1" required /> 4in1

                          <input type="checkbox" name="vaccine[]" id="cb3" value="Anti-Rabies" data-parsley-mincheck="1" required /> Anti-Rabies

                          <input type="checkbox" name="vaccine[]" id="cb4" value="Not Applicable" data-parsley-mincheck="1" required /> Not Applicable
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
                          <input class="form-control col-md-7 col-xs-12" type="number" name="weight" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Size <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="size" class="select2_single form-control" tabindex="-1" required>
                            <option></option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pet-medrec" class="control-label col-md-3 col-sm-3 col-xs-12">Medical Record <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="medrec" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Sociability <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="sociability" class="select2_single form-control" tabindex="-1" required>
                            <option></option>
                            <option value="1">Very Poor</option>
                            <option value="2">Poor</option>
                            <option value="3">Okay</option>
                            <option value="4">Good</option>
                            <option value="5">Superb</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Energy <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="energy" class="select2_single form-control" tabindex="-1" required>
                            <option></option>
                            <option value="1">Very Poor</option>
                            <option value="2">Poor</option>
                            <option value="3">Okay</option>
                            <option value="4">Good</option>
                            <option value="5">Superb</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Level of Affection <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="affection" class="select2_single form-control" tabindex="-1" required>
                            <option></option>
                            <option value="1">Very Poor</option>
                            <option value="2">Poor</option>
                            <option value="3">Okay</option>
                            <option value="4">Good</option>
                            <option value="5">Superb</option>
                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea" required="required" name="description" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pet-img1" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Image<span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" name="pet-img1" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pet-img2" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Image<span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" name="pet-img2" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pet-vid" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Adoptee Video<span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" accept="video/MOV, video/mp4" name="pet-vid">
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button name="pet-reset" class="btn btn-round  btn-primary" type="reset">Reset</button>
                          <button name="pet-submit" class="btn btn-round  btn-success" onclick="return confirm('Are you sure you want to submit this pet information?');">Submit</button>
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