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
    <title>Contact</title>
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
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header_start  -->
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
        <!-- header_start  -->

        <!-- bradcam_area_start -->
        <div class="bradcam_area breadcam_bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcam_text text-center">
                            <h3>We are always happy to hear from you</h3>
                            <br>
                            <h5>We value your comments and suggestions.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- ================ contact section start ================= -->

<section class="contact-section">
                <div class="container">

                    <div class="row">
                        <div class="col-12">
                            <h2 class="contact-title">Email us here:</h2>
                            <br>
                        </div>

                        <div class="col-lg-3 offset-lg-1">
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-home"></i></span>
                                <div class="media-body">
                                    <h3>Metro Manila, Philippines</h3>

                                </div>
                            </div>
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-email"></i></span>
                                <div class="media-body">
                                    <h3>warp.pup@gmail.com</h3>
                                    <p>Send us your query anytime!</p>
                            </div>
                    </div>
                </div>
            </section>
            <!-- ================ contact section end ================= -->
        <section class="blog_area single-post-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 posts-list">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="contact-title">Frequently Asked Questions (FAQ)</h2>
                            </div>
                        </div>
                        <div class="quote-wrapper">
                            <div class="quotes">
                                <h3>Please read FAQ before contacting us. </h3> <br>
                                <h4>We want to help you find the answers to your questions as quickly as possible, so please read our FAQ section before contacting us. Many of the questions we receive can be answered by reading through the FAQ.
                                    <br>
                                    If you still can???t find the answer to your question, then please contact us and we will be happy to help.
                                </h4>
                                <br>
                                <h4><b>Do you want a new furry friend?</b></h4>
                                <p>WARP provides an easy way to find adoptable pets near you in Metro Manila. <br>
                                    To get started, take a look at our available animals on the Pets for Adoption page.</p>
                                <br>
                                <h4><b>Do you need more information on adoption policies? </b></h4>
                                <p>Every adoption agency has different policies, so please contact the organization you're interested in working with directly for more information.
                                    Their contact details are posted on their own Animal Shelter Page. </p>
                                <br>
                                <h4><b>What Are The Requirements For Adopting A Pet?</b></h4>
                                <p>Before you can adopt a pet, you need to create an account and submit an application form.
                                    If you're interested in adopting one of our wonderful animals, please sign up or log into your account. After you finish and submit an application form,
                                    view your profile page to check the status of your submitted application. </p>
                                <br>
                                <p><b> Note: </b> To avoid a delay in your search for a pet, please contact the shelter directly with any questions you have about specific pets or
                                    policies. Each shelter manages its own pet list and information on WARP. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


            <!-- bradcam_area_end -->

            

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