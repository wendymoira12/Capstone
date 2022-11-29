<?php

include 'config.php';
session_start();

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
if (!isset($_GET['id'])) {
  die('Id not provided');
}

$id = $_GET['id'];
$sql = "SELECT * FROM adoptee_tbl WHERE pet_id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
  die('id not found');
}

$data = mysqli_fetch_assoc($result);
$chkvalues = explode(", ", $data["pet_vax"]);

?>

<!doctype html>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/b6742a828f.js" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Pet Profile - <?php echo $data['pet_name']; ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="shortcut icon" type="image/x-icon" href="../../img/favicon.png">
  <!-- Place favicon.ico in the root directory -->

  <!-- CSS here -->
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../../css/magnific-popup.css">
  <link rel="stylesheet" href="../../css/font-awesome.min.css">
  <link rel="stylesheet" href="../../css/themify-icons.css">
  <link rel="stylesheet" href="../../css/nice-select.css">
  <link rel="stylesheet" href="../../css/flaticon.css">
  <link rel="stylesheet" href="../../css/gijgo.css">
  <link rel="stylesheet" href="../../css/animate.css">
  <link rel="stylesheet" href="../../css/slicknav.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/AF.css">

  <!-- <link rel="stylesheet" href="css/responsive.css"> -->
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
                    <li><a href="shelter_adoptee_list.php">Back to Adoptee List</a></li>
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
            <h3>Pet &nbsp; Profile</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- bradcam_area_end -->

  <!--================Pet Profile =================-->

  <section class="blog_area single-post-area section-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 posts-list">
          <div class="single-post">
            <div class="single-item">
              <div class="slick">
                <img class="img-fluid" src="shelter/production/images/pet_img/<?= $data['pet_img']; ?>">
              </div>
              <div class="slick">
                <video width="300px" height="300px" controls>
                  <source src="shelter/production/images/pet_vid/<?= $data['pet_vid']; ?>" type="video/mp4">
                </video>
              </div>
            </div>


            <div class="blog_details">
              <h2 style="text-align: center;"><?php echo $data['pet_name']; ?></h2>

              <p class="excert">
                <b>Age:</b> <?php echo $data['pet_age']; ?><br>
                <b>Breed:</b> <?php echo $data['pet_breed']; ?><br>
                <b>Size:</b> <?php echo $data['pet_size']; ?><br>
                <b>Weight(kg):</b> <?php echo $data['pet_weight']; ?> kg<br>
                <b>Color:</b> <?php echo $data['pet_color']; ?><br>
                <b>Gender: </b> <?php echo $data['pet_gender']; ?> <br>
                <b>Neutered:</b> <?php echo $data['pet_neuter']; ?> <br>
                <b>Vaccine:</b> <?php echo $data['pet_vax']; ?> <br>
                <b>Medical Records:</b> <?php echo $data['pet_medrec']; ?> <br>

              </p>
              <div class="quote-wrapper">
                <div class="quotes">
                  <?php echo $data['pet_desc']; ?>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!--ADOPT ME! PAGE-->
        <div class="col-lg-4">
          <div class="blog_right_sidebar">

            <aside class="single_sidebar_widget instagram_feeds">
              <h4>Sociability</h4>
              <div class="star-rating">
                <ul class="list-inline">
                  <?php

                  $start = 1;
                  while ($start <= 5) {
                    if ($data['pet_lsoc'] < $start) {
                  ?>
                      <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                    <?php
                    } else {
                    ?>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                  <?php
                    }

                    $start++;
                  }
                  ?>
                </ul>
              </div>
              <h4>Energy</h4>
              <div class="star-rating">
                <ul class="list-inline">
                  <?php

                  $start = 1;
                  while ($start <= 5) {
                    if ($data['pet_lene'] < $start) {
                  ?>
                      <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                    <?php
                    } else {
                    ?>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                  <?php
                    }

                    $start++;
                  }
                  ?>
                </ul>
              </div>
              <h4>Affection</h4>
              <div class="star-rating">
                <ul class="list-inline">
                  <?php

                  $start = 1;
                  while ($start <= 5) {
                    if ($data['pet_laff'] < $start) {
                  ?>
                      <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                    <?php
                    } else {
                    ?>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                  <?php
                    }

                    $start++;
                  }
                  ?>
                </ul>
              </div>
              <br>
            </aside>

            <!--START OF POP UP APPLICATION FORM (html within an html)-->
            <html lang="en">

            <head>
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Document</title>
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
              <!--CSS HERE-->
              <link rel="stylesheet" href="AF.css">

            </head>

            <body>
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="modal-box">
                      <!-- ADOPT ME! - trigger ng application form pop up-->
                      <button type="button" class="btn btn-primary btn-lg show-modal" data-toggle="modal" data-target="#myModal" disabled>
                        Adopt Me!
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content clearfix">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <div class="modal-body">
                              <h3 class="title">Application Form</h3>
                              <p class="description">All fields are required</p>

                              <div class="form-group">
                                <span class="input-icon"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" placeholder="First Name" disabled>
                              </div>

                              <div class="form-group">
                                <span class="input-icon"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" placeholder="Last Name" disabled>
                              </div>

                              <div class="form-group">
                                <span class="input-icon"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" placeholder="Age" disabled>
                              </div>

                              <div class="form-group">
                                <span class="input-icon"><i class="fa fa-compass"></i></span>
                                <input type="email" class="form-control" placeholder="Home Address" disabled>
                              </div>

                              <div class="form-group">
                                <span class="input-icon"><i class="fa fa-phone"></i></span>
                                <input type="password" class="form-control" placeholder="Contact Number" disabled>
                              </div>

                              <div class="form-group checkbox">
                                <span class="input-icon"><i class="fa fa-at"></i></span>
                                <input type="password" class="form-control" placeholder="E-mail Address" disabled>
                              </div>


                              <!--Valid ID Picture-->
                              <div class="form-group">
                                <p>Please upload your Valid ID here for verification purposes:</p>
                                <input type="file" id="myfile" name="">
                              </div>

                              <!-- QUESTIONAIRRE -->

                              <div class="form-group checkbox">
                                <label>
                                  <b> Occupation</b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="recommed-1" name="occupation"> Student </input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="recommed-2" name="occupation"> Employed</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="recommed-3" name="occupation"> Self-emlpoyed</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Civil Status </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="recommed-1" name="Civil Status"> Single</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="recommed-2" name="Civil Status"> Married</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="recommed-3" name="Civil Status"> Widowed</input>
                                </label><br>
                                <label for="recommed-4">
                                  <input type="radio" id="recommed-4" name="Civil Status"> Separated</input>
                                </label><br>
                                <label for="recommed-5">
                                  <input type="radio" id="recommed-5" name="Civil Status"> Annuled</input>
                                </label><br>
                                <label for="recommed-6">
                                  <input type="radio" id="recommed-6" name="Civil Status"> CommonLaw</input>
                                </label><br>
                              </div>


                              <div class="form-group checkbox">
                                <label>
                                  <b> Are there children (below 18) in the house? If yes how old are they? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="old-1">
                                  <input type="radio" id="old-1" name="old"> There is a/are children below 8 years old</input>
                                </label><br>
                                <label for="old-2">
                                  <input type="radio" id="old-2" name="old"> All children in our house are older than 8 years old</input>
                                </label><br>
                                <label for="old-3">
                                  <input type="radio" id="old-3" name="old"> There is no children living in our house</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Do you have other children? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="recommed-1" name="children"> Yes</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="recommed-2" name="children"> No</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Have you had pets in the past? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="recommed-1" name="past"> Yes</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="recommed-2" name="past"> No</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Who else do you live with? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="recommed-1" name="live"> I live by myself</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="recommed-2" name="live"> Spouse/Partner</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="recommed-3" name="live"> Parents</input>
                                </label><br>
                                <label for="recommed-4">
                                  <input type="radio" id="recommed-4" name="live"> Roommate (s)</input>
                                </label><br>
                                <label for="recommed-5">
                                  <input type="radio" id="recommed-5" name="live"> Other Relatives</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Are any members of your household allergic to animals? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="members-1" name="members"> Yes</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="members-2" name="members"> No</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="members-3" name="members"> I don’t Know</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Who will be responsible for feeding, grooming, and generally caring for your pet? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="responsible-1">
                                  <input type="radio" id="responsible-1" name="responsible"> Myself</input>
                                </label><br>
                                <label for="responsible-2">
                                  <input type="radio" id="responsible-2" name="responsible"> My partner</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="recommed-3" name="responsible"> My Family</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b>
                                    Who will be financially responsible for your pet's needs </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="recommed-1">
                                  <input type="radio" id="financially-1" name="financially"> Myself</input>
                                </label><br>
                                <label for="recommed-2">
                                  <input type="radio" id="financially-2" name="financially"> My partner</input>
                                </label><br>
                                <label for="recommed-3">
                                  <input type="radio" id="financially-3" name="financially"> My Family</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Who will look after your pet if you go on vacation or in case of emergency? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="vacation-1">
                                  <input type="radio" id="vacation-1" name="vacation"> Partner</input>
                                </label><br>
                                <label for="vacation-2">
                                  <input type="radio" id="vacation-2" name="vacation"> Family</input>
                                </label><br>
                                <label for="vacation-3">
                                  <input type="radio" id="vacation-3" name="vacation"> Friends</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> How many hours in an average workday will your pet be left alone? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="hours-1">
                                  <input type="radio" id="hours-1" name="hours"> 1-4</input>
                                </label><br>
                                <label for="hours-2">
                                  <input type="radio" id="hours-2" name="hours"> 4-8</input>
                                </label><br>
                                <label for="hours-3">
                                  <input type="radio" id="hours-3" name="hours"> More than 8hrs</input>
                                </label><br>
                                <label for="hours-4">
                                  <input type="radio" id="hours-4" name="hours"> I work remotely </input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Does everyone in the family support your decision to adopt a pet? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="support-1">
                                  <input type="radio" id="support-1" name="support"> Yes</input>
                                </label><br>
                                <label for="support-2">
                                  <input type="radio" id="support-2" name="support"> No</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> What type of building do you live in? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="building-1">
                                  <input type="radio" id="building-1" name="building"> House </input>
                                </label><br>
                                <label for="building-2">
                                  <input type="radio" id="building-2" name="building"> Condo</input>
                                </label><br>
                                <label for="building-3">
                                  <input type="radio" id="building-3" name="building"> Apartment</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> If you rent, do you have permission from your landlord to have an animal? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="permission-1">
                                  <input type="radio" id="permission-1" name="permission"> Yes </input>
                                </label><br>
                                <label for="permission-2">
                                  <input type="radio" id="permission-2" name="permission"> No</input>
                                </label><br>
                                <label for="permission-3">
                                  <input type="radio" id="permission-3" name="permission"> I own</input>
                                </label><br>
                              </div>

                              <div class="form-group checkbox">
                                <label>
                                  <b> Are you prepared to spend for the wellness of your pet? If so, how much
                                    are you willing to spend in a year? </b>
                                </label><br>

                                <!-- Input Type Radio Button -->
                                <label for="prepared-1">
                                  <input type="radio" id="prepared-1" name="prepared"> Under 10,000 </input>
                                </label><br>
                                <label for="prepared-2">
                                  <input type="radio" id="prepared-2" name="prepared"> 10,000 - 20,000</input>
                                </label><br>
                                <label for="prepared-3">
                                  <input type="radio" id="prepared-3" name="prepared"> 20,001 – 40,000</input>
                                </label><br>
                                <label for="prepared-4">
                                  <input type="radio" id="prepared-4" name="prepared"> 40,001 – 60,000</input>
                                </label><br>
                                <label for="prepared-5">
                                  <input type="radio" id="prepared-5" name="prepared"> 60,001 – 80,000</input>
                                </label><br>
                              </div>

                              <button class="btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span> Cancel </button>
                              <a class="trigger_popup_fricc">
                                <button class="btn"> Submit </button>
                              </a>

                            </div>
                            <!--start popup confirmation message-->
                            <div class="hover_bkgr_fricc">
                              <span class="helper"></span>
                              <div>
                                <div class="popupCloseButton">&times;</div>
                                <p>
                                  <img src=img/logo.png>
                                <h4><b>Are you sure you want to proceed with your application?</h4><br />
                                </p>
                                <form action="#">
                                  <button class="button1" value="submit" formaction="submit.html"> Yes, I want to proceed </button>
                                  <button class="button1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span> Go Back </button>
                                  <!--end ConfirmationMessage-->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <!-- JS of the application form-->
              <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
              <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
              <!-- JS of the application form - then confirmation message after submitting-->
              <script src="../../confirmationmessage.js"></script>
            </body>

            </html>
            <!--END OF POP UP APPLICATION FORM-->


          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ Blog Area end =================-->

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
                <li><a href="#">warp@gmail.com</a></li>
                <li>Metro Manila, Philippines</li>
              </ul>
            </div>
          </div>
          <div class="col-xl-3  col-md-6 col-lg-3">
            <div class="footer_widget">
              <h3 class="footer_title">
                Quick Links
              </h3>
              <ul class="links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-3  col-md-6 col-lg-3">
            <div class="footer_widget">
              <h3 class="footer_title">

              </h3>
              <ul class="links">

              </ul>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-lg-3 ">
            <div class="footer_widget">
              <div class="footer_logo">
                <a href="#">
                  <img src="../../img/logo.png" alt="">
                </a>
              </div>
              <p class="address_text">Metro Manila, Philippines
              </p>
              <div class="socail_links">
                <ul>
                  <li>
                    <a href="#">
                      <i class="ti-facebook"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="ti-pinterest"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-google-plus"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-linkedin"></i>
                    </a>
                  </li>
                </ul>
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
  <script src="../../confirmationmessage.js"></script>
  <script src="//code.tidio.co/92loc9nlqb9hk1yax3unjiszh83m1tyy.js" async></script>
  <script src="../../js/vendor/modernizr-3.5.0.min.js"></script>
  <script src="../../js/vendor/jquery-1.12.4.min.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/owl.carousel.min.js"></script>
  <script src="../../js/isotope.pkgd.min.js"></script>
  <script src="../../js/ajax-form.js"></script>
  <script src="../../js/waypoints.min.js"></script>
  <script src="../../js/jquery.counterup.min.js"></script>
  <script src="../../js/imagesloaded.pkgd.min.js"></script>
  <script src="../../js/scrollIt.js"></script>
  <script src="../../js/jquery.scrollUp.min.js"></script>
  <script src="../../js/wow.min.js"></script>
  <script src="../../js/nice-select.min.js"></script>
  <script src="../../js/jquery.slicknav.min.js"></script>
  <script src="../../js/jquery.magnific-popup.min.js"></script>
  <script src="../../js/plugins.js"></script>
  <script src="../../js/gijgo.min.js"></script>


  <!--contact js-->
  <script src="../../js/contact.js"></script>
  <script src="../../js/jquery.ajaxchimp.min.js"></script>
  <script src="../../js/jquery.form.js"></script>
  <script src="../../js/jquery.validate.min.js"></script>
  <script src="../../js/mail-script.js"></script>

  <script src="../../js/main.js"></script>
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