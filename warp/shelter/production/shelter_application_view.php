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
// Pag naclick si reject button, mapapalitan yung application status sa application list
if (isset($_POST['submit-reject'])) {
  $id = $_GET['id'];
  $reject = 'Rejected';
  $sql = "UPDATE applicationresult_tbl SET application_status='$reject' WHERE application_id = '$id'";
  $result = $conn->query($sql);
  if ($result == TRUE) {
    header('Location: shelter_application_list.php');
  }

  $reject = '0';
  //notif para sa pagclick ng reject
  $msg = 'This shelter has rejected your adoptee application for pet'; //message sa notification ng adopter tas concat name ng pet na inadopt niya

  //Reason for rejecting 
  $msg1 = 'For the following reason/s: ' . $_POST['rejectmsg'];
  $sql_insert = mysqli_query($conn, "INSERT INTO adopternotif_tbl(application_id, message, message1, isAccepted) VALUES('$id', '$msg', '$msg1', '$reject')"); //Di ko alam pano ipapasok yung user_id para ma specify kung para kaninong adopter lang lalabas yung notif
  if ($sql_insert) {
    echo "<script>alert('Successfully cancelled adoption')</script>";
  } else {
    echo mysqli_error($conn);
    exit;
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
  <link rel="stylesheet" href="css/imagepopup.css">
  


  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->

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
              <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt="..." class="img-circle profile_img">
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
                <li><a href="shelter_account.php"><i class="fa fa-home"></i> Account </a>
                </li>
                <li><a href="shelter_adoptee_info.php"><i class="fa fa-edit"></i> Add Adoptee info </a>
                </li>
                <li><a href="shelter_adoptee_list.php"><i class="fa fa-paw"></i> Pet Adoptee List </a>
                </li>
                <li><a href="shelter_application_list.php"><i class="fa fa-paw"></i> Application List </a>
                </li>
                <li><a href="shelter_schedule_list.php"><i class="fa fa-paw"></i> Schedule List </a>
                </li>
                <li><a href="shelter_adopted_list.php"><i class="fa fa-paw"></i> Adopted Pet List </a>
                </li>
              </ul>
            </div>
          </div>

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
                  <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt=""><?php echo $_SESSION['user-email'] ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>
              <li> <a href="/Capstone/warp/home.php">Go to Homepage </i></a>
                <!-- Notification bell -->
                <?php

                $sql_get = mysqli_query($conn, "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, shelternotif_tbl.message, adoptee_tbl.pet_name FROM shelternotif_tbl INNER JOIN applicationform1 ON shelternotif_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE shelternotif_tbl.status = '0' AND applicationform1.application_id = shelternotif_tbl.application_id AND adoptee_tbl.city_id = '$city_id'");
                $count = mysqli_num_rows($sql_get);

                ?>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  <span class="badge bg-green"><?php echo $count; ?></span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <?php
                  if (mysqli_num_rows($sql_get) > 0) {
                    while ($notif = mysqli_fetch_assoc($sql_get)) {
                  ?>
                      <li>
                        <a>
                          <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                          <span>
                            <span><?php echo $notif['adopter_fname'] . ' ' . $notif['adopter_lname']; ?></span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            <?php echo $notif['message'] . ' ' . $notif['pet_name']; ?>
                          </span>
                        </a>
                      </li>
                  <?php
                    }
                  } else {
                    echo '<a > Sorry! No Notifications to show </a>';
                  }
                  ?>
                  <li>
                    <div class="text-center">
                      <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>

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

                  <form method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" name="id" for="pet-name">Adopter I.D: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <!-- Trigger the Modal by clicking the valid id -->
                        <img id="myImg" src="images/valid_id/<?= $qdata['valid_id']; ?>" alt="valid_id" style="width:100%;max-width:300px">
                            <div id="myModal" class="modal">
                              <span class="close">&times;</span>
                              <img class="modal-content" id="img01">
                            </div>
                      </div>
                    </div>

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
                        <input type="text" name="adopter_city" value="<?= $adata['adopter_currentadd'] ?>" class="form-control col-md-7 col-xs-12" disabled>
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

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="shelter_application_list.php">
                          <button class="btn btn-round btn-primary" type="button" onclick="return confirm('Are you sure you want to go back?');">Back</button>
                        </a>

                        <a href="#" data-toggle="modal" data-target="#modalReject">
                          <button name="reject" class="btn btn-round btn-danger">Reject</button>
                        </a>

                        <a href="accept_application.php?id=<?= htmlspecialchars($id)?>">
                          <button name="accept_application" type="button" class="btn btn-round btn-success">Accept</button>
                        </a>

                        <a href="report_generation.php?id=<?= htmlspecialchars($id) ?>">
                          <button class="btn btn-round btn-primary" type="button">View as PDF</button>
                        </a>
                      </div>

                      <?php
                      //Form Submission for dates
                      if (isset($_POST['submit-date'])) {
                        $date = $_POST['date'];
                        //If date is not empty code will execute
                        if (!empty($date)) {
                          //Sql query to check if data exist with same applicatin id in sched table
                          $sql = "SELECT * FROM schedule_tbl WHERE (application_id = '$id' AND deleted_at IS NULL) LIMIT 1";
                          $result = mysqli_query($conn, $sql);
                          if ($result->num_rows > 0) {
                            echo "<script>alert('Record Exists!')</script>";
                            echo "<script>window.location.href='shelter_application_list.php';</script>";
                          } else {
                            $sql2 = "INSERT INTO schedule_tbl(schedule_date, application_id) VALUES (?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                              echo "SQL Prepared Statement Failed";
                            } else {
                              mysqli_stmt_bind_param($stmt, "si", $date, $id);
                              mysqli_stmt_execute($stmt);
                              $scheduled = 'Scheduled';
                              $sql4 = "UPDATE applicationresult_tbl SET application_status= ? WHERE application_id = ?";
                              $stmt2 = mysqli_stmt_init($conn);
                              if (!mysqli_stmt_prepare($stmt2, $sql4)) {
                                echo "SQL Prepared Statement Failed";
                              } else {
                                mysqli_stmt_bind_param($stmt2, "si", $scheduled, $id);
                                mysqli_stmt_execute($stmt2);
                                echo "<script>alert('Date Input Success')</script>";
                                echo "<script>window.location.href='shelter_application_list.php';</script>";
                              }
                            }
                          }
                        } else {
                          echo "<script>alert('No date input')</script>";
                        }

                        //notif para sa pagaccept ng application form
                        $accept = '1';
                        $msg = 'This shelter has accepted your adoptee application for pet'; //message sa notification ng adopter tas concat name ng pet na inadopt niya
                        $msg1 = 'The scheduled date for your interview is'; //etong message1 naman naka null sya kase optional lang, if ever na nireject yung application form, wala tong laman kase wala namang massched
                        $sql_insert = mysqli_query($conn, "INSERT INTO adopternotif_tbl(application_id,  message, message1, isAccepted) VALUES('$id', '$msg', '$msg1', '$accept')"); //Di ko alam pano ipapasok yung user_id para ma specify kung para kaninong adopter lang lalabas yung notif
                        if ($sql_insert) {
                          echo "<script>alert('Successfully cancelled adoption')</script>";
                        } else {
                          echo mysqli_error($conn);
                          exit;
                        }
                      }

                      ?>
                      <div class="modal fade" id="modalDate">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <form action="/Capstone/warp/shelter/production/shelter_application_view.php?id=<?= $id ?>" method="POST">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Schedule a date for interview</h4>
                              </div>
                              <div class="modal-body">
                                <input type="date" name="date">
                              </div>
                              <div class="modal-footer">
                                <button class="btn btn-success" name="submit-date" onclick="return confirm('Are you sure you want to accept this application and proceed with the scheduled date?');">Submit
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      
                      <div class="modal fade" id="modalReject">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <form action="/Capstone/warp/shelter/production/shelter_application_view.php?id=<?= $id ?>" method="POST">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Please include the reason for rejection</h4>
                              </div>
                              <div class="modal-body">
                                <textarea name="rejectmsg"></textarea>
                              </div>
                              <div class="modal-footer">
                                <button class="btn btn-success" name="submit-reject" onclick="return confirm('Are you sure you want to reject this application?');">Submit
                                </button>
                              </div>
                            </form>
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
  <script>
          var modal = document.getElementById("myModal");
          var img = document.getElementById("myImg");
          var modalImg = document.getElementById("img01");
          img.onclick = function(){
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