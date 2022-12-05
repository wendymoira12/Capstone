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
    <link rel="stylesheet" href="css/footer_excess.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <header>
        <?php
        include "header.php"
        ?>
    </header>

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider slider_bg_1 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="slider_text">
                            <h3>Adopt from<br> <span>Animal Shelters</span></h3>
                            <p><b> Our listings include all ages and sizes, giving you plenty of options to choose from.
                                    We partner with local shelters and rescues to provide you with the cutest selection of pets in Metro Manila.</b> </hp>
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

    <!-- CONTAINS ALL FROM LIST OF SHELTERS TO WHY GO WITH WARP MESSAGE -->
    <div class="service_area">

        <!-- LISTING OF SHELTERS -->
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
                    if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $row) {
                    ?>

                            <div class="col-lg-4 col-md-6">
                                <div class="single_service">
                                    <a href="animal-shelter-page.php?id=<?= $row['city_id']; ?>&page=1">
                                        <!-- removed service_icon_bg_1 -->
                                        <div class="service_thumb d-flex align-items-center justify-content-center">
                                            <div class="service_icon">
                                                <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt="Shelter logo" height="200" width="200">
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
                </div>
            </div>
        <!-- LISTING OF SHELTERS -->

        <!-- TOTAL COUNTS HOME AREA  -->
            <div class="row justify-content-center">
                <div class="adapt_area">
                    <div class="container">
                        <!-- <div class="row justify-content-between align-items-center"> -->
                            <div class="col-lg-5">
                                <div class="adapt_help">
                                    <div class="section_title">
                                        <h3></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6"> -->
                                
                                <div class="adapt_about"> <!-- STYLE INSIDE BOX CONTAINER -->
                                    <div class="row align-items-center"> <!-- WIDTH OF BOX CONTAINER -->
                                    
                                        <!-- TOTAL ADOPTED PETS -->
                                            <div class="col-lg-6 col-md-6">
                                                    <?php
                                                    // Make a query to get the total adopted pets by COUNTing all the adopted_id with city id == which shelter city id
                                                    $sql = "SELECT COUNT(adopted_id) AS totaladoptedpet FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
                                                    $result = mysqli_query($conn, $sql);
                                                    if ($result) {
                                                        $data = mysqli_fetch_assoc($result);
                                                        $totaladoptedpet = $data['totaladoptedpet'];
                                                    }
                                                    ?>
                                                    <div class="single_adapt text-center">
                                                        <img src="img/adapt_icon/1.png" alt="">
                                                        <div class="adapt_content">
                                                            <h3 class="counter"><?= $totaladoptedpet ?></h3>
                                                            <p>Pets Adopted</p>
                                                        </div>
                                                    </div>
                                            </div>
                                        <!-- TOTAL ADOPTED PETS -->

                                        <!-- ADOPT NOW BUTTON -->
                                            <div class="col-lg-6 col-md-9">
                                                    <div class="pet_care_area">
                                                        <div class="container">
                                                            <div class="adapt_content">
                                                                <div class="section_title">
                                                                    <h3>
                                                                        We need your help
                                                                    </h3>
                                                                    <p>
                                                                        Adopt, don't shop. Save a life by adopting a pet from your local shelter.
                                                                    </p>
                                                                    <a href="pets_for_adoption.php" class="boxed-btn3">Adopt Now</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        <!-- ADOPT NOW BUTTON -->

                                        <!-- TOTAL AVAILABLE CATS -->
                                            <div class="col-lg-6 col-md-6">
                                                <?php
                                                // Make a query to get the total registered shelter accounts by COUNTing all the user with role id == 2
                                                $sql = "SELECT COUNT(pet_id) AS totalcats FROM adoptee_tbl WHERE pet_specie ='Cat' AND deleted_at IS NULL";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    $totalcats = $row['totalcats'];
                                                }
                                                ?>
                                                <div class="single_adapt text-center">
                                                    <img src="img/adapt_icon/3.png" alt="">
                                                    <div class="adapt_content">
                                                        <h3><span class="counter"><?= $totalcats ?></span>+</h3>
                                                        <p>Cats Available</p>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- TOTAL AVAILABLE CATS -->

                                        <!-- TOTAL AVAILABLE DOGS -->
                                            <div class="col-lg-6 col-md-6">
                                                <?php
                                                // Make a query to get the total registered shelter accounts by COUNTing all the user with role id == 2
                                                $sql = "SELECT COUNT(pet_id) AS totaldogs FROM adoptee_tbl WHERE pet_specie ='Dog' AND deleted_at IS NULL";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    $totaldogs = $row['totaldogs'];
                                                }
                                                ?>
                                                <div class="single_adapt text-center">
                                                    <img src="img/adapt_icon/2.png" alt="">
                                                    <div class="adapt_content">
                                                        <h3><span class="counter"><?= $totaldogs ?></span>+</h3>
                                                        <p>Dogs Available</p>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- TOTAL AVAILABLE DOGS -->

                                    </div>
                                </div>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        <!-- TOTAL COUNTS HOME AREA  -->



        <div class="contact_anipat anipat_bg_1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact_text text-center">
                            <div class="section_title text-center">
                                <h3>Why go with WARP</h3>
                                <p>We provide a safe and secured Animal Adoption Process. <br> For any concerns or suggestions contact us anytime!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- CONTAINS ALL FROM LIST OF SHELTERS TO WHY GO WITH WARP MESSAGE -->


    <!-- footer_start  -->
    <footer class="footer">
        <?php
        include "footer.php";
        ?>
    </footer>
    <!-- footer_end  -->



    <!-- JS here -->
    <!-- <script src="//code.tidio.co/92loc9nlqb9hk1yax3unjiszh83m1tyy.js" async></script> -->
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