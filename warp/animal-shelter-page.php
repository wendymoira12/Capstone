<?php

include('connect/connection.php');
session_start();

?>
<?php
if (isset($_GET['id']) && $_GET['page']) {
    $page_no = $_GET['page'];
}  
else {
    header('Location:/Capstone/warp/login.php'); 
}
// else {
//     die('Id not provided');
// }
$city_id = $_GET['id'];

// Query to check kung anong shelter
$sql = "SELECT * FROM city_tbl WHERE city_id='$city_id'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
}
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
    <header>
        <?php
        if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
            include "header_homeguest.php";
        } else {
            include "header.php";
        }
        ?>
    </header>

    <div class="bradcam_area breadcam_bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcam_text text-center">
                        <h3><?php echo $row['city_name']; ?></h3>
                        <br>
                        <h4 style="color:white;"> <img src="img/phone.svg" class="logo-img" width="30px" height="30px"> &nbsp <?php echo $row['city_contact']; ?> &nbsp &nbsp &nbsp &nbsp <img src="img/envelope-open.svg" width="30px" height="30px" class="logo-img">&nbsp
                            <?php if ($row['city_email'] == TRUE) {
                                echo $row['city_email'];
                            } else {
                                echo "&nbsp Not Available";
                            } ?></i></h4>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section_title text-center mb-95">
        <div class="col-lg-12">
            <br> <br>
            <blockquote class="generic-blockquote"> <?php echo $row['city_about']; ?></blockquote>
        </div>
    </div>

    <!-- service_area_start  -->

    <div class="section_title text-center mb-95">
        <h3>Pets Available for Adoption</h3>
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

                    $num_per_page = 9;
                    $offset = ($page_no - 1) * $num_per_page;
                    $previous_page = $page_no - 1;
                    $next_page = $page_no + 1;

                    // Query to get the total count of records
                    $pr_query = "SELECT COUNT(*) as total_records FROM warp_capstone.adoptee_tbl WHERE city_id='$city_id' AND deleted_at IS NULL";
                    $pr_result = mysqli_query($conn, $pr_query);
                    $records = mysqli_fetch_array($pr_result);
                    $total_record = $records['total_records'];
                    $total_page = ceil($total_record / $num_per_page);

                    $sql = "SELECT * FROM adoptee_tbl WHERE city_id='$city_id' AND deleted_at IS NULL LIMIT $offset,$num_per_page ";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $data) {
                    ?>
                            <div class="item" data-id="<?php echo $data['pet_specie']; ?>">
                                <div class="inner">
                                    <a href="AdopteePage.php?id=<?php echo $data['pet_id']; ?>">
                                        <img src="shelter/production/images/pet_img1/<?= $data['pet_img1']; ?>"> </a>
                                    <div class="service_content text-center">
                                        <a href="AdopteePage.php?id=<?php echo $data['pet_id']; ?>">
                                            <h3><?= $data['pet_name']; ?></h3>
                                        </a>
                                        <h5> 
                                            <b> Age:</b> <?= $data['pet_age']; ?> <br>
                                            <b> Size:</b> <?= $data['pet_size']; ?> <br>
                                            <b> Gender:</b> <?= $data['pet_gender']; ?> <br>
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
        <nav aria-label="Page navigation example">
            <div class="page">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled' : '' ?>" <?= ($page_no > 1) ? 'href=?id=' . $city_id . '&page=' . $previous_page : ''; ?>>Previous</a></li>

                    <?php for ($counter = 1; $counter <= $total_page; $counter++) { ?>
                        <?php if ($page_no != $counter) { ?>
                            <li class="page-item"><a class="page-link" <?= 'href=?id=' . $city_id . '&page=' . $counter; ?>><?= $counter ?></a></li>
                        <?php } else { ?>
                            <li class="page-item"><a class="page-link active"><?= $counter ?></a></li>
                        <?php } ?>
                    <?php } ?>
                    <li class="page-item"><a class="page-link <?= ($page_no >= $total_page) ? 'disabled' : ''; ?>" <?= ($page_no < $total_page) ? 'href=?id=' . $city_id . '&page=' . $next_page : ''; ?>>Next</a></li>
                </ul>
            </div>
        </nav>
    </section>

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