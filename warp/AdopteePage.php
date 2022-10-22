<?php
include 'config.php';

include('connect/connection.php');
session_start();

//if hindi nakaset si user-email and user-role-id babalik sya sa login.php

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'],$_SESSION['user_id'])) {
  header('Location:/Capstone/warp/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 1) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/Capstone/warp/home.php');
  }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM adopter_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $adopter_id = $row['adopter_id'];
  $sql = "SELECT * FROM user_tbl INNER JOIN adopter_tbl ON user_tbl.user_id = adopter_tbl.user_id WHERE user_tbl.user_id AND adopter_tbl.user_id ='$adopter_id'";
  $result = mysqli_query($conn, $sql);
  if ($result == TRUE) {
    $adopterresult = mysqli_fetch_assoc($result);
  }
}

?>
<?php
if (!isset($_GET['id']))
{
    die('Id not provided');
}

$id = $_GET['id'];
$sql = "SELECT * FROM adoptee_tbl WHERE pet_id = $id";

$result = $conn->query($sql);

if ($result->num_rows != 1)
{
    die('id not found');
}


$data = mysqli_fetch_assoc($result);
$chkvalues = explode(", ", $data["pet_vax"]);

?>
<?php 

if (isset($_POST['submit']))
    {

  $valid_id = $_FILES['valid_id']['name'];
  $valid_id_tmp_name = $_FILES['valid_id']['tmp_name'];
  $valid_id_folder = 'shelter/production/images/valid_id/' . $valid_id;
  
 $q1 = $_POST['occupation'];
 $q2 = $_POST["civilstatus"];
 $q3 = $_POST["children"];
 $q4 = $_POST["pets"];
 $q5 = $_POST["pastpets"];
 $q6 = $_POST["housing"];
 $q7 = $_POST["allergy"];
 $q8 = $_POST["wellness"];
 $q9 = $_POST["finance"];
 $q10 = $_POST["emergency"];
 $q11 = $_POST["alone"];
 $q12 = $_POST["support"];
 $q13 = $_POST["rent"];
 $q14 = $_POST['allow'];
 $q15 = $_POST['spending'];
  //$adopter = "SELECT * FROM a.adopter_tbl,u.user_tbl WHERE a.user_id=$_SESSION['user_id']";

  $row = "INSERT INTO applicationform1 (adopter_id,pet_id,valid_id,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15) VALUES ('$adopter_id','$id','$valid_id','$q1','$q2','$q3','$q4','$q5','$q6','$q7','$q8','$q9','$q10','$q11','$q12','$q13','$q14','$q15');";
  $query3 = mysqli_query($conn,$row); 
  /*{
  if(($q1 == "2" or $q1=="3")&&($q2=="5"or $q2=="6"or$q2=="7")&&($q3=="9"or $q3=="10")&&($q4 == "12")&&($q5=="13")&&($q6=="15"or $q6=="16"or $q6=="17"or $q6=="19")&&($q7 == "21")&&($q8=="23"or $q8=="24")&&($q9=="26")&&($q10 !== "32")&&($q11!=="35")&&($q12=="37")&&($q13=="40"or $q13=="41"or$q13=="42")&&($q14!=="44")&&($q15=="48"or$q15=="49"))
  {
    
    //sample data pa lang chineck lang kung papasok sa database
    $row1 = "INSERT INTO applicationresult_details (application_id, application_result, application_status) VALUES ('9','qualified','sample');";
    $query4 = mysqli_query($conn,$row1); 
  }
  //else {
    //$notqualified = 'Not qualified';
    $row2 = "INSERT INTO applicationresult_details (application_id, application_result, application_status) VALUES ('9','qualified','sample');";
    $query5 = mysqli_query($conn,$row2); 
  }
 
 }*/
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
    <link rel="stylesheet" href="css/AF.css">

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
                                            <li><a href="home.php">Home</a></li>
                                            <li> <a href="about.php">About Us </i></a>
                                            <li> <a href="pets-for-adoption.php">Pets for Adoption </i></a>
                                            <li><a href="contact.php">Contact</a></li>
                                            <li><a href="getroleid.php?id=<?= $_SESSION['user-role-id'] ?>"><i class="fa-solid fa-user" style="font-size:20px;color:rgb(4, 4, 41);"></i></a></li>
       
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
                            <div class="feature-img">
                                <img class="img-fluid" src="shelter/production/images/pet_img/<?= $data['pet_img']; ?>" width="400" height="600">
                            </div>
                            <div class="blog_details">
                                <h2><?php echo $data['pet_name']; ?>
                                </h2>

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

              <!-- STAR RATINGS IN LEVEL OF SOCABILITY, ENERGY, AFFECTION -->

                                    <aside class="single_sidebar_widget instagram_feeds">
                                      <h4>Sociability</h4>
                                      <div class="star-rating">
                                        <ul class="list-inline">
                                          <?php 
                                          
                                          $start=1;
                                          while ($start <= 5) 
                                          {
                                            if ($data['pet_lsoc'] < $start) 
                                              {
                                              ?>
                                              <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                              <?php
                                            }else{
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
                                          
                                          $start=1;
                                          while ($start <= 5) 
                                          {
                                            if ($data['pet_lene'] < $start) 
                                              {
                                              ?>
                                              <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                              <?php
                                            }else{
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
                                          
                                          $start=1;
                                          while ($start <= 5) 
                                          {
                                            if ($data['pet_laff'] < $start) 
                                              {
                                              ?>
                                              <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                              <?php
                                            }else{
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">  
<!--CSS HERE-->

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <div class="modal-box">
            <?php if($_SESSION['user-role-id']==1)?>
                <!-- ADOPT ME! - trigger ng application form pop up-->
                  <button type="button" class="btn btn-primary btn-lg show-modal" data-toggle="modal" data-target="#myModal">
                    Adopt Me!
                  </button>
 
                <!-- Modal -->
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content clearfix">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                              <div class="modal-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                <h3 class="title">Application Form</h3>
                                <p class="description"> Please make sure that al the details below are correct. Thank you!</p>
                                
                                <div class="form-group">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="fname" class="form-control" value="<?php echo $row['adopter_fname']; ?>" disabled>
                                </div>
                                
                                <div class="form-group">
                                  <span class="input-icon"><i class="fa fa-user"></i></span>
                                  <input type="text" name="lname" class="form-control" value="<?php echo $row['adopter_lname']; ?>" disabled>
                                </div>
                                
                                <div class="form-group">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="age" class="form-control" value="<?php echo $row['adopter_age']; ?>" disabled> 
                                </div>

                                <div class="form-group">
                                  <span class="input-icon"><i class="fa fa-compass"></i></span>
                                  <input type="text" name="city" class="form-control" value="<?php echo $row['adopter_city']; ?>, <?php echo $row['adopter_region']; ?>" disabled> 
                                </div>

                                <div class="form-group">
                                  <span class="input-icon"><i class="fa fa-phone"></i></span>
                                  <input type="text" name="number" class="form-control" value="<?php echo $row['adopter_cnum']; ?>" disabled> 
                                </div>

                                <div class="form-group checkbox">
                                  <span class="input-icon"><i class="fa fa-at"></i></span>
                                  <input type="email" name="email" class="form-control" value="<?php echo $row1['user_email']; ?>" disabled> 
                                </div>

                      
                                  <p><i>Please make sure that all details below are correct. Thank you!</i></p>


                                  <!--Valid ID Picture-->
                                <div class="form-group">
                                  <p>Please upload your Valid ID here for verification purposes:</p>
                                  <input class="form-control" type="file" name="valid_id" required>
                                </div>
                                
                              
                  
                                  <!-- QUESTIONAIRRE -->
                                  

                                <!-- q1: Occupation -->
                                <div class="form-group checkbox">
                                  <label>
                                    <!-- display ONLY q1 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '1'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                  </label><br>
                                                <!-- Radio Button Start: q1 - OCCUPATION -->
                                  <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '1'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='occupation' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                </div>
                                  <!-- END: q1-->
                                
                                  <!-- q2: Civil Status -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q2 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '2'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q2 - civilstatus -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '2'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='civilstatus' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q2-->

                            
                                  <!-- q3: CHILDREN -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q3 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '3'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q3 - CHILDREN -->
                                      <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '3'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='children' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                      </label><br>
                                  </div>
                                  <!-- END: q3-->
                            
                                  <!-- q4: PETS -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q4 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '4'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q4 - PETS -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '4'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='pets' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: 4-->
                            
                                  <!-- q5: past pets -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q5 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '5'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q5 - PASTPETS -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '5'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='pastpets' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q5-->

                                  <!-- q6: housing -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q6 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '6'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                                              <!-- Radio Button Start: q6 - HOUSING -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '6'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='housing' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q6 -->
                            
                                  <!-- q7: allergy -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q7 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '7'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions']; ?></b>
                                    </label><br>
                                                <!-- Radio Button Start: q7 - ALLERGY-->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '7'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='allergy' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q7-->
                            
                                  <!-- q8: in charge of wellness -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q8 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '8'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                      
                                                       <!-- Radio Button Start: q7 - WELLNESS -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '8'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='wellness' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                   <!-- END: q8 -->
                            
                                  <!-- q9: in charge financially -->
                                  <div class="form-group checkbox">
                                    label>
                                    <!-- display ONLY q9 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '9'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q9 - FINANCE -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '9'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='finance' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q9-->
                            
                                  <!-- q10: VACATION-->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q10 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '10'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q10 - VACATION -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '10'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='emergency' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END q10-->
                            
                                  <!-- q11: alone-->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q11 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '11'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                              <!-- Radio Button Start: q11 - ALONE -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '11'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='alone' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                <!-- END: q11-->

                                  <!-- q12: SUPPORT -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q12 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '12'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q12 - SUPPORT -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '12'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='support' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                  <!-- END: q12 -->
                            
                                  <!-- q13: rent -->
                                  <div class="form-group checkbox">
                                    <label>
                                      <!-- display ONLY q13 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '13'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                          <!-- Radio Button Start: q13 - RENT -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '13'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='rent' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                <!-- END: q13-->
                                              
                                  <!-- q14: permission -->
                                  <div class="form-group checkbox">
                                    <label>
                                      <!-- display ONLY q14 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '14'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                                            <!-- Radio Button Start: q14 - ALLOW -->

                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '14'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='allow' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                <!-- END q14 -->
                            
                                <!-- Radio Button Start: q15 - spending -->
                                  <div class="form-group checkbox">
                                    <label>
                                      <!-- display ONLY q15 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '15'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo $question['questions'];?></b>
                                    </label><br>
                            
                            
                                            <!-- Input Type Radio Button name: spending-->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '15'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='spending' value = "<?php echo $row['id']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label>
                                  </div>
                                <!-- END q15-->
                                  
                                  
                                <button class="btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span> Cancel </button>
                                <input class = "btn" type="submit" name="submit" value="submit"onclick="return confirm('Are you sure you want to proceed?');">
                                
                              </div>
                              </form>
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
<script src="confirmationmessage.js"></script>
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
        <script src="confirmationmessage.js"></script>
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