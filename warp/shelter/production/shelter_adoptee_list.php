<?php

include 'config.php';
session_start();

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
  header('Location:/Capstone/warp/login.php');
}

if (isset($_GET['pet-delete'])) {
  $id = $_GET['pet-delete'];
  mysqli_query($conn, "DELETE FROM adoptee_tbl WHERE pet_id = $id");
  header('Location: shelter_adoptee_list.php');
}

$i = 1;

// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];
// Query to check if user_id from the login shesh to get the shelter user (will be replacing user_id to Shelter City as WHERE for multiple access)
$sql = "SELECT * FROM shelter_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

// If true get shelter id from the shelter table para maspecify kung alin adoptee ang ishoshow based sa shelter_id 
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $shelter_id = $row['shelter_id'];
  $sql = "SELECT shelter_tbl.shelter_id, adoptee_tbl.pet_id, adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_vax, adoptee_tbl.pet_weight, adoptee_tbl.pet_size, adoptee_tbl.pet_medrec, adoptee_tbl.pet_lsoc, adoptee_tbl.pet_lene, adoptee_tbl.pet_laff, adoptee_tbl.pet_desc, adoptee_tbl.pet_img FROM adoptee_tbl INNER JOIN shelter_tbl ON adoptee_tbl.shelter_id = shelter_tbl.shelter_id WHERE adoptee_tbl.shelter_id = '$shelter_id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Animal Shelter | Adoptee Pet List</title>
      <link rel="shortcut icon" type="image/x-icon" href="/warp/img/WARP_LOGO copy.png">
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
      <link href="../build/css/custom.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/warp/shelter/production/css/style.css">
    </head>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">
          <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
              <div class="logo">
                <a href="home.html">
                  <img src="/warp/img/logo.png" alt="">
                </a>
              </div>
              <div class="clearfix"></div>


              <!-- menu profile quick info -->
              <div class="profile clearfix">
                <div class="profile_pic">
                  <img src="../../img/shelters/Las_Piñas_City_seal.png" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                  <span>Welcome,</span>
                  <h2>
                    <?php
                    //DISPLAY SESSION
                    if (isset($_SESSION['user-email'])) {
                      echo $_SESSION['user-email'];
                    } else {
                      header('Location:/Capstone/warp/login.php');
                    }
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
                    <li><a href="shelter_account.php"><i class="fa fa-home"></i> Account </a>
                    </li>
                    <li><a href="shelter_adoptee_info.php"><i class="fa fa-edit"></i> Add Adoptee info </a>
                    </li>
                    <li><a href="shelter_adoptee_list.php"><i class="fa fa-paw"></i> Pet Adoptee List </a>
                    </li>
                    <li><a href="shelter_adopted_list.php"><i class="fa fa-paw"></i> Adopted Pet List </a>
                    </li>
                    <li><a href="shelter_application_list.php"><i class="fa fa-paw"></i> Application List </a>
                    </li>
                  </ul>
                </div>

              </div>
              <!-- /sidebar menu -->



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
                      <img src="/warp/img/City Logo/last_pinas.png" alt=""><?php echo $_SESSION['user-email']?>
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
                  <h3>List of Pet Adoptees</h3>
                </div>

                <div class="title_right">

                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4>This table shows all the pet that is up for adoption in this animal shelter. </h4>

                    </li>
                    </ul>

                  </div>

                  <p class="text-muted font-13 m-b-30">

                    <!-- DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code> -->
                  </p>
                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No. </th>
                        <th>Pet ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Color</th>
                        <th>Breed</th>
                        <th>Specie</th>
                        <th>Sex</th>
                        <th>Neuter</th>
                        <th>Vax</th>
                        <th>Weight</th>
                        <th>Size</th>
                        <th>Medical Record</th>
                        <th>Level of Sociability</th>
                        <th>Level of Energy</th>
                        <th>Level of Affection</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>


                    <tbody>

                      <?php

                      while ($row = $result->fetch_assoc()) {

                      ?>

                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['pet_id']; ?></td>
                          <td><?php echo '<img src="images/' . $row['pet_img'] . '" alt="pet" width="100">'; ?></td>
                          <td><?php echo $row['pet_name']; ?></td>
                          <td><?php echo $row['pet_age']; ?></td>
                          <td><?php echo $row['pet_color']; ?></td>
                          <td><?php echo $row['pet_breed']; ?></td>
                          <td><?php echo $row['pet_specie']; ?></td>
                          <td><?php echo $row['pet_gender']; ?></td>
                          <td><?php echo $row['pet_neuter']; ?></td>
                          <td><?php echo $row['pet_vax']; ?></td>
                          <td><?php echo $row['pet_weight']; ?>kg</td>
                          <td><?php echo $row['pet_size']; ?></td>
                          <td><?php echo $row['pet_medrec']; ?></td>
                          <td><?php echo $row['pet_lsoc']; ?></td>
                          <td><?php echo $row['pet_lene']; ?></td>
                          <td><?php echo $row['pet_laff']; ?></td>
                          <td><?php echo $row['pet_desc']; ?></td>
                          <td>
                            <a href="shelter_adoptee_view.php?id=<?php echo $row['pet_id']; ?>">
                              <button type="button" class="btn btn-round btn-info">view</button>
                            </a>

                            <a href="shelter_adoptee_edit.php?id=<?php echo $row['pet_id']; ?>">
                              <button type="button" class="btn btn-round btn-success">Edit</button>
                            </a>

                            <a href="shelter_adoptee.delete.php?id=<?php echo $row['pet_id']; ?>">
                              <button type="button" class="btn btn-round btn-danger" onclick="submitData(<?php echo $row['pet_id']; ?>);">Delete</button>
                            </a>
                          </td>
                        </tr>

                  <?php
                      }
                    }
                  }
                  ?>
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

    </body>

    </html>