<?php

include('connect/connection.php');
session_start();

?>
<?php
if (!isset($_GET['id'])) {
    die('Id not provided');
}
$city_id = $_GET['id'];

// Query to check kung anong shelter
$sql = "SELECT * FROM city_tbl WHERE city_id='$city_id'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
?>

    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Animal Shelter</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link rel="manifest" href="site.webmanifest"> -->
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <!-- Place favicon.ico in the root directory -->

        <!-- CSS here -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/themify-icons.css">
        <link rel="stylesheet" href="css/nice-select.css">
        <link rel="stylesheet" href="css/flaticon.css">
        <link rel="stylesheet" href="css/gijgo.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/slicknav.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    </head>

    <body>

        </head>

        <body>
        <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="home.php">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="home.php">Home</a></li>
                                        <li> <a href="about.php">About Us </i></a>
                                        <li> <a href="pets-for-adoption.php">Pets for Adoption </i></a>
                                        <li><a href="contact.php">Contact</a></li>
                                        <li><a href="getroleid.php?id=<?= $_SESSION['user-role-id'] ?>">
                                                <i class="fa-solid fa-user" style="font-size:20px;color:rgb(4, 4, 41);"></i></a>
                                        </li>
                                        <li><a href="logout.php?logout">Logout </a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

            <div class="bradcam_area breadcam_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="bradcam_text text-center">
                                <h3><?php echo $row['city_name']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- service_area_start  -->
            <div class="service_area">
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="col-lg-7 col-md-10">
                            <div class="section_title text-center mb-95">
                                <h3>Pets Available for Adoption</h3>
                            </div>
                        </div>
                    </div>
                    <section class="portfolio" id="Portfolio">
                        <div class="container">
                            <div class="row">
                                <div class="filter-buttons">
                                    <ul id="filter-btns">
                                        <li class="active" data-target="all">ALL</li>
                                        <li data-target="Cat">CAT</li>
                                        <li data-target="Dog">DOG</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="portfolio-gallery">
                                    <?php
                                    $sql = "SELECT * FROM adoptee_tbl WHERE city_id='$city_id'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        foreach ($result as $data) {
                                    ?>
                                            <div class="item" data-id="<?php echo $data['pet_specie']; ?>">
                                                <div class="inner">
                                                    <a href="AdopteePage.php?id=<?php echo $data['pet_id']; ?>">
                                                        <img src="shelter/production/images/pet_img/<?= $data['pet_img']; ?>"> </a>
                                                    <div class="service_content text-center">
                                                        <a href="AdopteePage.php?id=<?php echo $data['pet_id']; ?>">
                                                            <h3><?= $data['pet_name']; ?></h3>
                                                        </a>
                                                        <h5> <b> Gender:</b> <?= $data['pet_gender']; ?> <br>
                                                            <b> Age:</b> <?= $data['pet_age']; ?> <br>
                                                            <b> Size:</b> <?= $data['pet_size']; ?> <br>
                                                            <b> Neutered:</b> <?= $data['pet_neuter']; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                <?php
                                        }
                                    } else {
                                        echo "No records found";
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>


                        <!-- ================ footer ================= -->

                        <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-lg-3">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    Contact Us
                                </h3>
                                <ul class="address_line">
                                    <li>warp.pup@gmail.com</li>
                                    <li>Metro Manila, Philippines</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3  col-md-6 col-lg-3">
                            <div class="footer_widget">

                            </div>
                        </div>
                        <div class="col-xl-3  col-md-6 col-lg-3">
                            <div class="footer_widget">
                                <h3 class="footer_title">

                                </h3>
                                <ul class="links">
                                    <br>

                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 ">
                            <div class="footer_widget">
                                <div class="footer_logo">
                                    <a href="#">
                                        <img src="img/logo.png" alt="">
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right_text">
                <div class="container">
                    <div class="bordered_1px"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <p class="copy_right text-center">

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
                        <!-- footer_end  -->

                        <!-- JS here -->
                        <script src="//code.tidio.co/92loc9nlqb9hk1yax3unjiszh83m1tyy.js" async></script>
                        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
                        <script src="js/vendor/jquery-1.12.4.min.js"></script>
                        <script src="js/popper.min.js"></script>
                        <script src="js/bootstrap.min.js"></script>
                        <script src="js/owl.carousel.min.js"></script>
                        <script src="js/isotope.pkgd.min.js"></script>
                        <script src="js/ajax-form.js"></script>
                        <script src="js/waypoints.min.js"></script>
                        <script src="js/jquery.counterup.min.js"></script>
                        <script src="js/imagesloaded.pkgd.min.js"></script>
                        <script src="js/scrollIt.js"></script>
                        <script src="js/jquery.scrollUp.min.js"></script>
                        <script src="js/wow.min.js"></script>
                        <script src="js/nice-select.min.js"></script>
                        <script src="js/jquery.slicknav.min.js"></script>
                        <script src="js/jquery.magnific-popup.min.js"></script>
                        <script src="js/plugins.js"></script>
                        <script src="js/gijgo.min.js"></script>

                        <!--contact js-->
                        <script src="js/contact.js"></script>
                        <script src="js/jquery.ajaxchimp.min.js"></script>
                        <script src="js/jquery.form.js"></script>
                        <script src="js/jquery.validate.min.js"></script>
                        <script src="js/mail-script.js"></script>

                        <script src="js/main.js"></script>
                        <script>
                            $('#datepicker').datepicker({
                                iconsLibrary: 'fontawesome',
                                disableDaysOfWeek: [0, 0],
                                //     icons: {
                                //      rightIcon: '<span class="fa fa-caret-down"></span>'
                                //  }
                            });
                            $('#datepicker2').datepicker({
                                iconsLibrary: 'fontawesome',
                                icons: {
                                    rightIcon: '<span class="fa fa-caret-down"></span>'
                                }

                            });
                            var timepicker = $('#timepicker').timepicker({
                                format: 'HH.MM'
                            });
                        </script>
        </body>

    </html>