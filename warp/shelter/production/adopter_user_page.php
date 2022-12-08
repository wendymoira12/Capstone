<?php
include 'config.php';
session_start();

//if hindi nakaset si user-email and user-role-id babalik sya sa login.php

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'], $_SESSION['user_id'])) {
  header('Location:/Capstone/warp/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 1) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/Capstone/warp/home.php');
  }
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM adopter_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $adopter_id = $row['adopter_id'];
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
  <title>Adopter | My Applications</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom1.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/adopter_editprofile.css">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="logo">

          </div>
          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <a href="">
              <img src="images/logo.png" alt="">
            </a>
            <div class="profile_pic">


              <img id="myBtn" src="images/user.png" alt="..." class="img-circle profile_img">
              <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                  <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Modal Header</h2>
                  </div>
                  <div class="modal-body">
                    <p>Some text in the Modal Body</p>
                    <p>Some other text...</p>
                  </div>
                  <div class="modal-footer">
                    <h3>Modal Footer</h3>
                  </div>
                </div>

              </div>

            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $row['adopter_fname']; ?></h2>
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
              <li><a href="/Capstone/warp/logout.php?logout">Logout </i></a>
              <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
                <!-- Notification bell -->
                <?php

                $sqlr = "SELECT city_tbl.city_name, city_tbl.city_img, adoptee_tbl.pet_name, adopternotif_tbl.message, adopternotif_tbl.message1, adopternotif_tbl.isAccepted, adopter_tbl.user_id, adopternotif_tbl.adopternotif_date FROM adopternotif_tbl INNER JOIN applicationform1 ON adopternotif_tbl.application_id = applicationform1.application_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id WHERE adopternotif_tbl.status = '0' AND adoptee_tbl.city_id = city_tbl.city_id AND adopter_tbl.user_id = '$user_id' ORDER BY adopternotif_tbl.adopternotif_date DESC";
                $resultr = mysqli_query($conn, $sqlr);
                $count = mysqli_num_rows($resultr);

                $notifdate = mysqli_fetch_assoc($resultr);
                include "time_ago_adopter.php";

                /*$sql_get = mysqli_query($conn, "SELECT * FROM adopternotif_tbl INNER JOIN applicationform1 ON adopternotif_tbl.application_id = applicationform1.application_id INNER JOIN schedule_tbl ON applicationform1.schedule_id = schedule_tbl.schedule_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adopternotif_tbl.status = 0"); //PANO Q GAGAWIN YUNG SCHEDULE_TBL.APPLICATION_ID = APPLICATIONFORM1.APPLICATION_ID para tama yung dates dun sa notif
                $count = mysqli_num_rows($sql_get);*/

                ?>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  <span class="badge bg-green"><?php echo $count; ?></span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <?php
                  if (mysqli_num_rows($resultr) > 0) {
                    while ($notif = mysqli_fetch_assoc($resultr)) {
                  ?>
                      <li>
                        <a>
                          <span class="image"><?php echo '<img src="images/logo/' . $notif['city_img'] . '" alt="shelter logo"'; ?></span>
                          <span>
                            <span class="time">
                              <?php 
                              $unixTimestamp = convertToUnixTimestamp($notifAt);
                              echo convertToAgoFormat($unixTimestamp);
                              ?></span>
                            <span"><?php echo $notif['city_name']; ?></span>
                          </span>
                          <span class="message">
                            <?php
                            //Pag rejected, yung message lang at pet name
                            if ($notif['isAccepted'] == '3') {
                              echo $notif['message'] . ' ' . $notif['pet_name'] . '. ';
                              echo $notif['message1'];
                            } else if ($notif['isAccepted'] == '1') {
                              $sql3 = "SELECT schedule_date FROM schedule_tbl";
                              $result3 = mysqli_query($conn, $sql3);
                              $data3 = mysqli_fetch_assoc($result3);
                              //Pag accepted, message pati yung isang message with pet name and schedule ng interview
                              echo $notif['message'] . ' ' . $notif['pet_name'] . '. ' . $notif['message1'] . ' ' . $data3['schedule_date'];
                            } else {
                              $sql4 = "SELECT schedule_date FROM schedule_tbl";
                              $result4 = mysqli_query($conn, $sql4);
                              $data4 = mysqli_fetch_assoc($result4);
                              //Pag pinalitan ni shelter yung interview date, dito lalabas
                              echo $notif['message'] . ' ' . $data4['schedule_date'] . '. ' . $notif['message1'] . ' ' . $notif['pet_name'];
                            }
                            ?>
                          </span>
                        </a>
                      </li>
                  <?php
                    }
                  } else {
                    echo '<a > Sorry! No Notifications to show </a>';
                  }
                  ?>
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
              <h3>My Application List</h3>
            </div>



            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Applications</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Application ID</th>
                          <th>Pet Name</th>
                          <th>Date Submitted</th>
                          <th>Application Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $i = 1;
                        //Columns needed to query = No., Date Submitted, Adopter Name, Adoptee name, Application Status
                        $sqlapp = "SELECT applicationform1.date_submitted, applicationform1.adopter_id, applicationform1.pet_id, applicationresult_tbl.application_status, applicationform1.application_id, adoptee_tbl.pet_name FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id WHERE adopter_tbl.adopter_id = '$adopter_id'";

                        //$sqlapp= "SELECT * FROM applicationform1, applicationresult_tbl WHERE adopter_id ='$adopter_id';";

                        $result = mysqli_query($conn, $sqlapp);
                        if ($result->num_rows > 0) {
                          foreach ($result as $data) {

                        ?>
                            <tr>
                              <th><?= $i++; ?></th>
                              <th><?php echo $data['application_id']; ?></th>
                              <th><?php echo $data['pet_name']; ?></th>
                              <td><?php echo $data['date_submitted']; ?></td>
                              <td>
                                <?php 
                                if($data['application_status'] == 'Rejected'){
                                  $app_id = $data['application_id'];
                                  $sql = "SELECT message1 FROM adopternotif_tbl WHERE application_id = '$app_id'";
                                  $result = mysqli_query($conn, $sql);
                                  $data1 = mysqli_fetch_assoc($result);
                                  echo $data['application_status'];
                                  ?> <br>
                                  <?php echo $data1['message1'];
                                }else{
                                  echo $data['application_status'];
                                }
                                ?>
                              </td>
                              <td>
                                <a href="adopter_application_view.php?id=<?= $data['application_id']; ?>">
                                  <?php
                                    $app_id = $data['application_id'];
                                    $disable = "SELECT application_id, application_status from applicationresult_tbl WHERE application_id='$app_id'";
                                    $qdisable = mysqli_query($conn, $disable); 
                                  ?>
                                  <button type="button" class="btn btn-round btn-success"
                                  <?php
                                  
                                  if ($qdisable->num_rows != 0) {
                                          $fdisable = mysqli_fetch_assoc($qdisable);
                                          $var=$fdisable['application_status'];

                                          if ($var != "Pending") {
                
                                            ?> disabled <?php 
                                            }
                                          }
                                      ?>>View</button>
                                </a>
                              </td>
                            </tr>
                        <?php
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
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var img = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    img.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>

</html>