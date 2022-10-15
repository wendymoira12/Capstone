<?php
include 'config.php';
include('connect/connection.php');
session_start();

//if hindi nakaset si user-email and user-role-id babalik sya sa login.php
if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
    header('Location: login.php');
}

$sql = "SELECT * FROM city_tbl";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>WARP Home Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/WARP_LOGO copy.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="ss/font-awesome.min.css">
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
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

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
                                        <li> <a href="newpage.php">Pets for Adoption </i></a>
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

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider slider_bg_1 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="slider_text">
                            <h3>Adopt from<br> <span>Animal Shelters</span></h3>
                            <p>Browse pets from our network in Metro Manila shelters and rescues.</p>
                            <a href="contact.php" class="boxed-btn4">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dog_thumb d-none d-lg-block">
                <img src="img/banner/puppy.png" alt="">
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- service_area_start  -->
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-7 col-md-10">
                    <div class="section_title text-center mb-95">
                        <h3>List of Metro Manila Animal Shelters</h3>
                        <p>Find your future furfriend! Browse from different Animal Shelters below.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Check if may existing na shelter na ishoshow -->
                <?php
                if(mysqli_num_rows($result) > 0) {
                    foreach($result as $row) {
                ?>
                
                    <div class="col-lg-4 col-md-6">
                        <div class="single_service">
                            <a href="animal-shelter-page.php?id=<?php echo $row['city_id']; ?>">
                                <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                                    <div class="service_icon">
                                        <img src="shelter/production/images/logo/<?= $row['city_img']; ?>" alt="Shelter logo" height="100" width="100">
                                    </div>
                                </div>
                                <div class="service_content text-center">
                                        <h3><?php echo $row['city_name']; ?></h3>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php
                    }
                } else {
                    echo "No records found";
                }
                ?>

                <!-- <div class="col-lg-4 col-md-6">
                    <div class="single_service active">
                        <div class="service_thumb service_icon_bg_2 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <a href="Las-Pinas-Animal-Shelter.php">
                                <h3>Las Piñas</h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_3 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Quezon City</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_4 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Caloocan</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_5 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Makati</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_6 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Malabon</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_7 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Mandaluyong</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_8 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Marikina</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_9 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Muntinlupa</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_10 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Navotas</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_11 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Parañaque</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_12 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Pasay</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_13 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Pasig</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_14 d-flex align-items-center justify-content-center">

                        </div>
                        <div class="service_content text-center">
                            <h3>San Juan</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_15 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Taguig</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_16 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Valenzuela</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                        <div class="service_thumb service_icon_bg_17 d-flex align-items-center justify-content-center">
                        </div>
                        <div class="service_content text-center">
                            <h3>Pateros</h3>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- service_area_end -->

        <!-- pet_care_area_start  -->
        <div class="pet_care_area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="pet_thumb">
                            <img src="img/about/pet_care.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-6">
                        <div class="pet_info">
                            <div class="section_title">
                                <h3><span>We care your pet </span> <br>
                                    As you care</h3>
                                <p></p>
                                <a href="about.php" class="boxed-btn3">About Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pet_care_area_end  -->

        <!-- adapt_area_start  -->
        <div class="adapt_area">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5">
                        <div class="adapt_help">
                            <div class="section_title">
                                <h3><span>We need your</span>
                                    help Adopt Us</h3>
                                <p></p>
                                <a href="contact.php" class="boxed-btn3">Contact Us</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="adapt_about">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <div class="single_adapt text-center">
                                        <img src="img/adapt_icon/1.png" alt="">
                                        <div class="adapt_content">
                                            <h3 class="counter">452</h3>
                                            <p>Pets Adopted</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="single_adapt text-center">
                                        <img src="img/adapt_icon/3.png" alt="">
                                        <div class="adapt_content">
                                            <h3><span class="counter">52</span>+</h3>
                                            <p>Cats Available</p>
                                        </div>
                                    </div>
                                    <div class="single_adapt text-center">
                                        <img src="img/adapt_icon/2.png" alt="">
                                        <div class="adapt_content">
                                            <h3><span class="counter">52</span>+</h3>
                                            <p>Dogs Available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- adapt_area_end  -->



        <div class="contact_anipat anipat_bg_1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact_text text-center">
                            <div class="section_title text-center">
                                <h3>Why go with WARP</h3>
                                <p>We provide a safe and secured Animal Adoption Process. <br> For any concerns or suggestions contact us anytime!</p>
                            </div>
                            <div class="contact_btn d-flex align-items-center justify-content-center">
                                <a href="contact.php" class="boxed-btn4">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- footer_start  -->
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
                                    <li></li>
                                    <li>warp.pup@gmail.com</a></li>
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