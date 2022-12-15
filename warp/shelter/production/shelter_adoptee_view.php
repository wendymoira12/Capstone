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

<?php
$sql = "SELECT * FROM applicationform1";
$result = $conn->query($sql);

if (!$result) {
  trigger_error('Invalid query: ' . $conn->error);
}
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
  <link rel="shortcut icon" type="image/x-icon" href="/Capstone/warp/img/WARP_LOGO copy.png">
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
 <!-- SLIDER CSS AND JS -->
 <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

  <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>
<!-- SLIDER STYLE -->
<style type="text/css">
  html,
  body {
    margin: 0;
    padding: 0;
  }

  * {
    box-sizing: border-box;
  }

  .slider {
    width: 30%;
    margin: 30px auto;
    width: 200px;
  }

  .slick-slide {
    margin: 0px 10px;
    width: 50vw;
    box-sizing: border-box;
  }

  .slick-slide img {
    width: 300px;
    margin: auto;
  }

  .slick-prev:before,
  .slick-next:before {
    color: black;
  }


  .slick-slide {
    transition: all ease-in-out .3s;
    opacity: .2;
  }

  .slick-active {
    opacity: .5;
  }

  .slick-current {
    opacity: 1;
  }

  div.slick {
    text-align: center;
  }
</style>
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
                    <li><a href="shelter_adoptee_list.php" style="text-decoration: none">Back to Adoptee List</a></li>
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
                <img class="cropped1" src="images/pet_img1/<?= $data['pet_img1']; ?>">
              </div>
              <div class="slick">
                <img class="cropped1" src="images/pet_img2/<?= $data['pet_img2']; ?>">
              </div>
              <div class="slick">
                <video width="300px" height="300px" controls>
                  <source src="images/pet_vid/<?= $data['pet_vid']; ?>" type="video/mp4">
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
                <b>This pet was </b> <?php echo $data['pet_origin']; ?> <br>

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

                            </div>
                            <!--start popup confirmation message-->
                           
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
      <?php
        include "../../footer.php";
      ?>
    </footer>
  <!-- footer_end  -->


  <!-- JS here -->
  <script src="../../confirmationmessage.js"></script>
  <!-- <script src="//code.tidio.co/92loc9nlqb9hk1yax3unjiszh83m1tyy.js" async></script> -->
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

<!-- SLIDER-->
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script type="text/javascript">
    $(document).on('ready', function() {
      $('.single-item').slick();
    });
    $('.one-time').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true
    });
    $('.single-item-rtl').slick({
      rtl: true
    });
  </script>
  
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