<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['email-login'])) {
    header('Location: login.php');
}
?>

<?php
if (isset($_POST['submit_reset'])) {
    unset($_SESSION['start_date'], $_SESSION['end_date'], $_SESSION['city']);
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
    <link rel="shortcut icon" type="image/x-icon" href="/Capstone/warp/img/WARP_LOGO copy.png">
    <title>WARP Admin</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

</head>

<!-- Nav Sidebar  -->

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="admin_home.php" class="site_title"><i class="fa fa-paw"></i> <span>WARP</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/WARP_LOGO.svg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>
                                <?php
                                //DISPLAY SESSION
                                if (isset($_SESSION['email-login'])) {
                                    echo $_SESSION['email-login'];
                                } else {
                                    header("Location: login.php");
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
                                <li><a href="admin_home.php"><i class="fa fa-home"></i> Home <span></span></a></li>
                                <li><a href="manage_city.php"><i class="fa fa-building-o"></i> Manage Cities </a></li>
                                <li><a><i class="fa fa-users"></i> Manage Accounts </a>
                                    <ul class="nav child_menu">
                                        <li><a href="manage_shelter.php">Shelter</a></li>
                                        <li><a href="manage_adopter.php">Adopter</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-print"></i> Generate Reports <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="report_admin_adoptee_list.php"><i class="fa fa-table"></i>Adoptee List</a>
                                        <li><a href="report_admin_application_list.php"><i class="fa fa-table"></i>Application List</a>
                                        <li><a href="report_admin_schedule_list.php"><i class="fa fa-table"></i>Schedule List</a>
                                        <li><a href="report_admin_adopted_list.php"><i class="fa fa-table"></i>Adopted List</a>
                                        </li>
                                    </ul>
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
                                    <img src="images/WARP_LOGO.svg" alt=""><?php echo $_SESSION['email-login'] ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="logout.php?logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Schedule List</h3>
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

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" name="submit_date" class="btn btn-success">Filter</button>
                                        <a href="report_shelter_application_list.php"><button name="submit_reset" class="btn btn-danger" type="submit">Reset</button></a>
                                        <a href="reportadmin_schedule_list_pdf.php" target="_blank"><button name="viewPDF" class="btn btn-primary" type="button">View as PDF</button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <form action="" method="POST">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <?php
                                        //To query the city names and id from city table
                                        $sql = "SELECT city_id, city_name FROM city_tbl WHERE deleted_at IS NULL";
                                        $result = mysqli_query($conn, $sql);
                                        ?>
                                        <select class="select2_single form-control" tabindex="-1" name="city">
                                            <option></option>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                foreach ($result as $row) {
                                            ?>
                                                    <option value="<?= $row['city_id'] ?>"><?= $row['city_name'] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <p class="text-muted">&nbsp; City Name</p>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" name="submit_city" class="btn btn-success">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="row">
                    <br>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <?php
                                if (isset($_POST['submit_date'])) {

                                    $start_date = $_POST['start_date'];
                                    $end_date = $_POST['end_date'];

                                    $_SESSION['start_date'] = $_POST['start_date'];
                                    $_SESSION['end_date'] = $_POST['end_date'];

                                    $i = 1;
                                    $sql = "SELECT schedule_tbl.schedule_id, schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, schedule_tbl.application_id, adopter_tbl.adopter_id, city_tbl.city_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id  WHERE (schedule_tbl.schedule_date BETWEEN '$start_date' and '$end_date')";
                                    $result1 = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result1) > 0) {
                                        $total = mysqli_num_rows($result1);
                                ?>

                                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Scheduled Date</th>
                                                    <th>Adopter Name</th>
                                                    <th>City</th>
                                                    <th>Adoptee Name</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($result1 as $data1) { ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $data1['schedule_date'] ?></td>
                                                        <td><?= $data1['adopter_fname'] . ' ' . $data1['adopter_lname']; ?></td>
                                                        <td><?= $data1['city_name']; ?></td>
                                                        <td><?= $data1['pet_name']; ?></td>
                                                    </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    <?php
                                    } else {

                                        echo "No Record Found";
                                    }
                                } else if (isset($_POST['submit_city'])) {
                                    $city_id = $_POST['city'];
                                    $_SESSION['city'] = $_POST['city'];
                                    $i = 1;
                                    $sql = "SELECT schedule_tbl.schedule_id, schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, schedule_tbl.application_id, adopter_tbl.adopter_id, city_tbl.city_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id  WHERE adoptee_tbl.city_id = '$city_id'";
                                    $result2 = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result2) > 0) {
                                        $total = mysqli_num_rows($result2);
                                    ?>

                                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Scheduled Date</th>
                                                    <th>Adopter Name</th>
                                                    <th>City</th>
                                                    <th>Adoptee Name</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($result2 as $data2) { ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $data2['schedule_date'] ?></td>
                                                        <td><?= $data2['adopter_fname'] . ' ' . $data2['adopter_lname']; ?></td>
                                                        <td><?= $data2['city_name']; ?></td>
                                                        <td><?= $data2['pet_name']; ?></td>
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
                                                <th>No.</th>
                                                <th>Scheduled Date</th>
                                                <th>Adopter Name</th>
                                                <th>City</th>
                                                <th>Adoptee Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $sql = "SELECT schedule_tbl.schedule_id, schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, schedule_tbl.application_id, adopter_tbl.adopter_id, city_tbl.city_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result->num_rows > 0) {
                                                foreach ($result as $data) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $data['schedule_date'] ?></td>
                                                        <td><?= $data['adopter_fname'] . ' ' . $data['adopter_lname']; ?></td>
                                                        <td><?= $data['city_name']; ?></td>
                                                        <td><?= $data['pet_name']; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "No Record Found";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- PRIMARY TABLE - SHOWS ALL DATA -->
                                <?php }
                                ?>
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
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

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
</body>

</html>