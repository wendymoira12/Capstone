<?php
session_start();

use LDAP\Result;

include('connect/connection.php');
if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    else
    {
        $page = 1;
    }

    $num_per_page = 03;
    $start_from = ($page-1)*03;
    
    $query = "SELECT * FROM warp_capstone.adoptee_tbl LIMIT $start_from,$num_per_page";
    $result = mysqli_query($conn,$query);
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pet for Adoption</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/WARP_LOGO copy.png">
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
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <header>
            <?php
            if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
                include "header_homeguest.php";
            } else {
                include "header.php";
            }
            ?>
        </header>

        <!-- header_start  -->
        <!-- bradcam_area_start -->
        <div class="bradcam_area breadcam_bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcam_text text-center">
                            <h3>Pets Available for Adoption</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- bradcam_area_end -->
        <br>

        <!-- ======= Portfolio Section ======= -->


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
                        ?>
                    </div>
                </div>
            </div>
            <?php 
        
                $pr_query = "SELECT * FROM adoptee_tbl";
                $pr_result = mysqli_query($conn,$pr_query);
                $total_record = mysqli_num_rows($pr_result );
                
                $total_page = ceil($total_record/$num_per_page);
                ?>
<nav aria-label="Page navigation example">
<div class="page">
  <ul class="pagination">
  <?php
                if($page>1)
                {
                    echo "<a href='pets-for-adoption.php?page=".($page-1)."' class='page-item'>Previous</a>";
                }
                
                for($i=1;$i<$total_page;$i++)
                {
                    echo "<a href='pets-for-adoption.php?page=".$i."' class='page-item'>$i</a>";
                }

                if($i>$page)
                {
                    echo "<a href='pets-for-adoption.php?page=".($page+1)."' class='page-item'>Next</a>";
                }
        
        ?>
        </ul>
        </div>     
</nav>
            <!-- footer_start  -->
            <footer class="footer">
                <?php
                include "footer.php";
                ?>
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