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
?>
<?php
$i = 1;

// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];
// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $city_id = $row['city_id'];
  $sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
  $result2 = mysqli_query($conn, $sql);
  if ($result2 == TRUE) {
    $row2 = mysqli_fetch_assoc($result2);
  }
}
?>

<?php
if (isset($_POST['submit_reset'])) {
  unset($_SESSION['start_date'], $_SESSION['end_date'], $_SESSION['specie'], $_SESSION['gender'], $_SESSION['size'], $_SESSION['neuter']);
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

  <title> <?php echo $row2['city_name']; ?> | Adoptee Pet List</title>
  <link rel="shortcut icon" type="image/x-icon" href="/img/WARP_LOGO copy.png">
  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
                  <img src="/shelter/production/images/logo/<?= $row2['city_img']; ?>" alt=""><?= $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="changepass.php"><i class="fa fa-wrench pull-right"></i>Change Password</a></li>
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
              <h3>List of Pet Adoptees</h3>
              <br>
            </div>
          </div>

          <div class="x_content">
            <div class="col-md-10 col-sm-12 col-xs-12">
              <!-- DATA FILTER -->
              <form method="post" action="">

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">
                    <input type="date" name="start_date" class="form-control">
                    <p class="text-muted">&nbsp; Start Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-lg-3 col-sm-3 col-xs-6">
                  <div class="form-group">

                    <input type="date" name="end_date" class="form-control">
                    <p class="text-muted">&nbsp; End Date (mm/dd/yyyy)</p>
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_date" class="btn btn-success">Filter</button>
                    <a href="report_shelter_adoptee_list.php"><button name="submit_reset" class="btn btn-danger" type="submit">Reset</button></a>
                    <a href="report_adoptee_list_pdf.php" target="_blank"><button name="viewPDF" class="btn btn-primary" type="button">View as PDF</button></a>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="x_content">
            <div class="col-md-10 col-sm-12 col-xs-12">
              <form action="" method="POST">
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select name="specie" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Dog">Dog</option>
                      <option value="Cat">Cat</option>
                    </select>
                    <p class="text-muted">&nbsp; Specie</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_specie" class="btn btn-success">Filter</button>
                  </div>
                </div>

                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select name="gender" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <p class="text-muted">&nbsp; Gender</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_gender" class="btn btn-success">Filter</button>
                  </div>
                </div>

                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select name="size" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Small">Small</option>
                      <option value="Medium">Medium</option>
                      <option value="Large">Large</option>
                    </select>
                    <p class="text-muted">&nbsp; Size</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_size" class="btn btn-success">Filter</button>
                  </div>
                </div>

                <div class="col-md-2 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select name="neuter" class="select2_single form-control" tabindex="-1">
                      <option></option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                    <p class="text-muted">&nbsp; Neuter</p>
                  </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-12">
                  <div class="form-group">
                    <button type="submit" name="submit_neuter" class="btn btn-success">Filter</button>
                  </div>
                </div>
              </form>
            </div>
          </div>


          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <!-- PRIMARY TABLE - SHOWS ALL DATA -->
                <div class="x_content">
                  <?php

                  if (isset($_POST['submit_date'])) {

                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    $_SESSION['start_date'] = $_POST['start_date'];
                    $_SESSION['end_date'] = $_POST['end_date'];

                    $i = 1;
                    $sql = "SELECT * FROM adoptee_tbl WHERE (created_at BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
                    $result1 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result1) > 0) {
                      $total = mysqli_num_rows($result1);
                  ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                          <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Color</th>
                            <th>Breed</th>
                            <th>Specie</th>
                            <th>Sex</th>
                            <th>Neuter</th>
                            <th>This pet has been</th>
                            <th>Vax</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Medical Record</th>
                            <th>Level of Sociability</th>
                            <th>Level of Energy</th>
                            <th>Level of Affection</th>
                            <th>Date Created</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result1 as $data1) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data1['pet_name']; ?></td>
                              <td><?= $data1['pet_age']; ?></td>
                              <td><?= $data1['pet_color']; ?></td>
                              <td><?= $data1['pet_breed']; ?></td>
                              <td><?= $data1['pet_specie']; ?></td>
                              <td><?= $data1['pet_gender']; ?></td>
                              <td><?= $data1['pet_neuter']; ?></td>
                              <td><?= $data1['pet_origin']; ?></td>
                              <td><?= $data1['pet_vax']; ?></td>
                              <td><?= $data1['pet_weight']; ?>kg</td>
                              <td><?= $data1['pet_size']; ?></td>
                              <td><?= $data1['pet_medrec']; ?></td>
                              <td><?= $data1['pet_lsoc']; ?></td>
                              <td><?= $data1['pet_lene']; ?></td>
                              <td><?= $data1['pet_laff']; ?></td>
                              <td><?= $data1['created_at']; ?></td>
                              <td><?= $data1['pet_desc']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>

                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH SPECIE FILTER
                  else if (isset($_POST['submit_specie'])) {
                    $specie = $_POST['specie'];

                    $_SESSION['specie'] = $_POST['specie'];

                    $i = 1;
                    $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_specie = '$specie' AND adoptee_tbl.city_id = '$city_id'";
                    $result2 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result2) > 0) {
                      $total = mysqli_num_rows($result2);
                    ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                          <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Color</th>
                            <th>Breed</th>
                            <th>Specie</th>
                            <th>Sex</th>
                            <th>Neuter</th>
                            <th>This pet has been</th>
                            <th>Vax</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Medical Record</th>
                            <th>Level of Sociability</th>
                            <th>Level of Energy</th>
                            <th>Level of Affection</th>
                            <th>Date Created</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result2 as $data2) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data2['pet_name']; ?></td>
                              <td><?= $data2['pet_age']; ?></td>
                              <td><?= $data2['pet_color']; ?></td>
                              <td><?= $data2['pet_breed']; ?></td>
                              <td><?= $data2['pet_specie']; ?></td>
                              <td><?= $data2['pet_gender']; ?></td>
                              <td><?= $data2['pet_neuter']; ?></td>
                              <td><?= $data2['pet_origin']; ?></td>
                              <td><?= $data2['pet_vax']; ?></td>
                              <td><?= $data2['pet_weight']; ?>kg</td>
                              <td><?= $data2['pet_size']; ?></td>
                              <td><?= $data2['pet_medrec']; ?></td>
                              <td><?= $data2['pet_lsoc']; ?></td>
                              <td><?= $data2['pet_lene']; ?></td>
                              <td><?= $data2['pet_laff']; ?></td>
                              <td><?= $data2['created_at']; ?></td>
                              <td><?= $data2['pet_desc']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>

                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH GENDER FILTER
                  else if (isset($_POST['submit_gender'])) {
                    $gender = $_POST['gender'];

                    $_SESSION['gender'] = $_POST['gender'];

                    $i = 1;
                    $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_gender = '$gender' AND adoptee_tbl.city_id = '$city_id'";
                    $result3 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result3) > 0) {
                      $total = mysqli_num_rows($result3);
                    ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                          <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Color</th>
                            <th>Breed</th>
                            <th>Specie</th>
                            <th>Sex</th>
                            <th>Neuter</th>
                            <th>This pet has been</th>
                            <th>Vax</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Medical Record</th>
                            <th>Level of Sociability</th>
                            <th>Level of Energy</th>
                            <th>Level of Affection</th>
                            <th>Date Created</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result3 as $data3) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data3['pet_name']; ?></td>
                              <td><?= $data3['pet_age']; ?></td>
                              <td><?= $data3['pet_color']; ?></td>
                              <td><?= $data3['pet_breed']; ?></td>
                              <td><?= $data3['pet_specie']; ?></td>
                              <td><?= $data3['pet_gender']; ?></td>
                              <td><?= $data3['pet_neuter']; ?></td>
                              <td><?= $data3['pet_origin']; ?></td>
                              <td><?= $data3['pet_vax']; ?></td>
                              <td><?= $data3['pet_weight']; ?>kg</td>
                              <td><?= $data3['pet_size']; ?></td>
                              <td><?= $data3['pet_medrec']; ?></td>
                              <td><?= $data3['pet_lsoc']; ?></td>
                              <td><?= $data3['pet_lene']; ?></td>
                              <td><?= $data3['pet_laff']; ?></td>
                              <td><?= $data3['created_at']; ?></td>
                              <td><?= $data3['pet_desc']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH SIZE FILTER
                  else if (isset($_POST['submit_size'])) {
                    $size = $_POST['size'];

                    $_SESSION['size'] = $_POST['size'];

                    $i = 1;
                    $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_size = '$size' AND adoptee_tbl.city_id = '$city_id'";
                    $result4 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result4) > 0) {
                      $total = mysqli_num_rows($result4);
                    ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                          <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Color</th>
                            <th>Breed</th>
                            <th>Specie</th>
                            <th>Sex</th>
                            <th>Neuter</th>
                            <th>This pet has been</th>
                            <th>Vax</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Medical Record</th>
                            <th>Level of Sociability</th>
                            <th>Level of Energy</th>
                            <th>Level of Affection</th>
                            <th>Date Created</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result4 as $data4) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data4['pet_name']; ?></td>
                              <td><?= $data4['pet_age']; ?></td>
                              <td><?= $data4['pet_color']; ?></td>
                              <td><?= $data4['pet_breed']; ?></td>
                              <td><?= $data4['pet_specie']; ?></td>
                              <td><?= $data4['pet_gender']; ?></td>
                              <td><?= $data4['pet_neuter']; ?></td>
                              <td><?= $data4['pet_origin']; ?></td>
                              <td><?= $data4['pet_vax']; ?></td>
                              <td><?= $data4['pet_weight']; ?>kg</td>
                              <td><?= $data4['pet_size']; ?></td>
                              <td><?= $data4['pet_medrec']; ?></td>
                              <td><?= $data4['pet_lsoc']; ?></td>
                              <td><?= $data4['pet_lene']; ?></td>
                              <td><?= $data4['pet_laff']; ?></td>
                              <td><?= $data4['created_at']; ?></td>
                              <td><?= $data4['pet_desc']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>
                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }

                  // SHOWS DATA WITH SPECIE FILTER
                  else if (isset($_POST['submit_neuter'])) {
                    $neuter = $_POST['neuter'];

                    $_SESSION['neuter'] = $_POST['neuter'];

                    $i = 1;
                    $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_neuter = '$neuter' AND adoptee_tbl.city_id = '$city_id'";
                    $result5 = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result5) > 0) {
                      $total = mysqli_num_rows($result5);
                    ?>

                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                          <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Color</th>
                            <th>Breed</th>
                            <th>Specie</th>
                            <th>Sex</th>
                            <th>Neuter</th>
                            <th>This pet has been</th>
                            <th>Vax</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Medical Record</th>
                            <th>Level of Sociability</th>
                            <th>Level of Energy</th>
                            <th>Level of Affection</th>
                            <th>Date Created</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($result5 as $data5) { ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data5['pet_name']; ?></td>
                              <td><?= $data5['pet_age']; ?></td>
                              <td><?= $data5['pet_color']; ?></td>
                              <td><?= $data5['pet_breed']; ?></td>
                              <td><?= $data5['pet_specie']; ?></td>
                              <td><?= $data5['pet_gender']; ?></td>
                              <td><?= $data5['pet_neuter']; ?></td>
                              <td><?= $data5['pet_origin']; ?></td>
                              <td><?= $data5['pet_vax']; ?></td>
                              <td><?= $data5['pet_weight']; ?>kg</td>
                              <td><?= $data5['pet_size']; ?></td>
                              <td><?= $data5['pet_medrec']; ?></td>
                              <td><?= $data5['pet_lsoc']; ?></td>
                              <td><?= $data5['pet_lene']; ?></td>
                              <td><?= $data5['pet_laff']; ?></td>
                              <td><?= $data5['created_at']; ?></td>
                              <td><?= $data5['pet_desc']; ?></td>
                            </tr>
                          <?php  } ?>
                        </tbody>
                      </table>

                    <?php
                    } else {
                      echo "No Record Found";
                    }
                  }
                  // SHOWS DATA WITH NO FILTER
                  else {
                    ?>
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No. </th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Color</th>
                          <th>Breed</th>
                          <th>Specie</th>
                          <th>Sex</th>
                          <th>Neuter</th>
                          <th>This pet has been</th>
                          <th>Vax</th>
                          <th>Weight</th>
                          <th>Size</th>
                          <th>Medical Record</th>
                          <th>Level of Sociability</th>
                          <th>Level of Energy</th>
                          <th>Level of Affection</th>
                          <th>Date Created</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT * FROM adoptee_tbl WHERE city_id='$city_id'";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                          foreach ($result as $data) {
                        ?>
                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $data['pet_name']; ?></td>
                              <td><?= $data['pet_age']; ?></td>
                              <td><?= $data['pet_color']; ?></td>
                              <td><?= $data['pet_breed']; ?></td>
                              <td><?= $data['pet_specie']; ?></td>
                              <td><?= $data['pet_gender']; ?></td>
                              <td><?= $data['pet_neuter']; ?></td>
                              <td><?= $data['pet_origin']; ?></td>
                              <td><?= $data['pet_vax']; ?></td>
                              <td><?= $data['pet_weight']; ?>kg</td>
                              <td><?= $data['pet_size']; ?></td>
                              <td><?= $data['pet_medrec']; ?></td>
                              <td><?= $data['pet_lsoc']; ?></td>
                              <td><?= $data['pet_lene']; ?></td>
                              <td><?= $data['pet_laff']; ?></td>
                              <td><?= $data['created_at']; ?></td>
                              <td><?= $data['pet_desc']; ?></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                    <!-- PRIMARY TABLE - SHOWS ALL DATA -->
                  <?php } ?>
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

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
    });
  </script>
</body>

</html>