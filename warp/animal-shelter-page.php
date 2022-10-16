<?php

include('connect/connection.php');

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
   <title>Animal Shelter - Las Pinas</title>
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
                                    <a href="home.html">
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
                                            <li></li>
                                            <a href="../warp/shelter/production/adopter_user_page.php"><i class="fa-solid fa-user" style="font-size:28px;color:rgb(4, 4, 41);"></i></a>
    
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
                   <h3><?php echo $row['city_name']; ?></h3>
               </div>
           </div>
       </div>
   </div>
</div>
<!-- bradcam_area_end -->
<!-- service_area_start  -->
<div class="service_area">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-7 col-md-10">
                <div class="section_title text-center mb-95">
                    <h3>Pets Available for Adoption</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                </div>
            </div>
        </div>
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">
      
              <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                  <ul id="portfolio-flters">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-app">DOG</li>
                    <li data-filter=".filter-card">CAT</li>
                  </ul>
                </div>
              </div>

        <div class="row justify-content-center">
            <?php
                if(!isset($_GET['id'])){
                    die('Id not provided');
                }
                $id = $_GET['id'];

                // If true get shelter id from the shelter table para maspecify kung alin adoptee ang ishoshow based sa shelter_id 
                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $sql = "SELECT city_tbl.city_id, adoptee_tbl.pet_id, adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_vax, adoptee_tbl.pet_weight, adoptee_tbl.pet_size, adoptee_tbl.pet_medrec, adoptee_tbl.pet_lsoc, adoptee_tbl.pet_lene, adoptee_tbl.pet_laff, adoptee_tbl.pet_desc, adoptee_tbl.pet_img FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
            ?>
                <div class="col-lg-4 col-md-6 portfolio-item filter-Cat">
                                        <div class="single_service">
                                            <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                                                <div class="service_icon">
                                                    <a href="AdopteePage.php?id=<?php echo $row['pet_id']; ?>">
                                                        <img src="shelter/production/images/pet_img/<?= $row['pet_img']; ?>" width="200" height="215">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="service_content text-center">
                                                <a href="AdopteePage.php?id=<?php echo $row['pet_id']; ?>">
                                                    <h3><?= $row['pet_name'];?></h3>
                                                </a>
                                                <h5>Gender: <?= $row['pet_gender']; ?> <br>
                                                Age: <?= $row['pet_age']; ?> <br>
                                                Size: <?= $row['pet_size']; ?> <br>
                                                Neutered: <?= $row['pet_neuter']; ?>
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
                }
                else {
                header('Location:shelter_account.php');
                }
            ?>

        </div>
    </div>

<!-- ================ contact section start ================= -->
<!--
<section class="contact-section">
        <div class="container">
            
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Send them a Message</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Name"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Las Piñas, Philippines</h3>
                          
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>8225-2911 <br> 0965-653-6449 </h3>
                            
                            <p>Mon to Fri 8am to 5pm</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>laspinasanimalshelter@gmail.com</h3>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->
<!-- ================ contact section end ================= -->



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