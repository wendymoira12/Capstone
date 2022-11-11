

<?php
/*<!--<?php         
$app1d = "SELECT * from applicationresult_tbl ORDER BY application_id DESC;";
$query9 = mysqli_query($conn,$app1d);
$row9 = mysqli_fetch_assoc($query9);
if ($app1d['application_status'] != "Cancelled by adopter" && "Rejected" ){ 
  ?> disabled 
  <?php   
} ?>-->*/
include 'config.php';
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
$sql = "SELECT * FROM applicationform1";
$result = $conn->query($sql);

if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
}
?>
<?php 

if (isset($_POST['submit']))
  {

  // kuhain yung mga sagot sa application form lagay sa database: applicationform1
  $valid_id = $_FILES["valid_id"]["name"];
  $valid_id_tmp_name = $_FILES['valid_id']['tmp_name'];
  $valid_id_folder = "shelter/production/images/valid_id/" . $valid_id;
  
 
  $q1 = mysqli_real_escape_string($conn,$_POST["occupation"]);
  $q2 = mysqli_real_escape_string($conn,$_POST["civilstatus"]);
  $q3 = mysqli_real_escape_string($conn,$_POST["children"]);
  $q4 = mysqli_real_escape_string($conn,$_POST["pets"]);
  $q5 = mysqli_real_escape_string($conn,$_POST["pastpets"]);
  $q6 = mysqli_real_escape_string($conn,$_POST["housing"]);
  $q7 = mysqli_real_escape_string($conn,$_POST["allergy"]);
  $q8 = mysqli_real_escape_string($conn,$_POST["wellness"]);
  $q9 = mysqli_real_escape_string($conn,$_POST["finance"]);
  $q10 = mysqli_real_escape_string($conn,$_POST["emergency"]);
  $q11 = mysqli_real_escape_string($conn,$_POST["alone"]);
  $q12 = mysqli_real_escape_string($conn,$_POST["support"]);
  $q13 = mysqli_real_escape_string($conn,$_POST["rent"]);
  $q14 = mysqli_real_escape_string($conn,$_POST["allow"]);
  $q15 = mysqli_real_escape_string($conn,$_POST["spending"]);
  $address = mysqli_real_escape_string($conn,$_POST["address"]);

  $row = "INSERT INTO applicationform1 (adopter_id,pet_id,adopter_address,valid_id,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15) VALUES ('$adopter_id','$id','$address','$valid_id','$q1','$q2','$q3','$q4','$q5','$q6','$q7','$q8','$q9','$q10','$q11','$q12','$q13','$q14','$q15');";
  $query3 = mysqli_query($conn,$row); 
  
  //move_uploaded_file($valid_id, 'shelter/production/images/valid_id/');
  //$insert = $mysqli -> affected_rows;
  //mysqli_close($conn);

  //tulog muna ng mga 4 seconds para smooth sa next process
  usleep(250000);
  {
   // $appsql = "SELECT application_id FROM applicationform1 WHERE adopter_id ='$adopter_id';";
  
    // base sa sagot, isa isa kukuhain yung katumbas na value niya galing sa questionchoices na table sa "correct" na column, pag 1 correct pag 0 hindi.
    
        $app1d = "SELECT application_id from applicationform1 WHERE adopter_id='$adopter_id';";
        $appresult = mysqli_query($conn,$app1d);

        if ($appresult->num_rows > 0){

            $row9 = mysqli_fetch_assoc($appresult);
            $final1=implode($row9);
              //move_uploaded_file($valid_id_tmp_name, $valid_id_folder);

            /* $app1d = "SELECT application_id from applicationform1 WHERE adopter_id='$adopter_id' ORDER BY application_id DESC;";
              $query9 = mysqli_query($conn,$app1d);
              $row9 = mysqli_fetch_assoc($query9);
              $final1=implode($row9);*/
              
              //q1 fetch
              $sqlresult1 = "SELECT correct FROM questionchoices WHERE choices='$q1'AND questionID=1;";
              $queryr1 = mysqli_query($conn,$sqlresult1);
              $row1 = mysqli_fetch_assoc($queryr1);
              $ffinal1=implode($row1);
            // echo $ffinal1.",";
            
              //q2 fetch
              $sqlresult2 = "SELECT correct FROM questionchoices WHERE choices='$q2' AND questionID=2;";
              $queryr2 = mysqli_query($conn,$sqlresult2);
              $row2 = mysqli_fetch_assoc($queryr2);
              $final2=implode($row2);
              //echo $final2.",";
            
              //q3 fetch
            $sqlresult3 = "SELECT correct FROM questionchoices WHERE choices='$q3' AND questionID=3;";
              $queryr3 = mysqli_query($conn,$sqlresult3);
              $row3 = mysqli_fetch_assoc($queryr3);
              $final3=implode($row3);
              //echo $final3.",";
            
              //q4 fetch
              $sqlresult4 = "SELECT correct FROM questionchoices WHERE choices='$q4' AND questionID=4;";
              $queryr4 = mysqli_query($conn,$sqlresult4);
              $row4 = mysqli_fetch_assoc($queryr4);
              $final4=implode($row4);
              //echo $final4.","; 
            
              //q5 fetch
            $sqlresult5 = "SELECT correct FROM questionchoices WHERE choices='$q5' AND questionID=5;";
              $queryr5 = mysqli_query($conn,$sqlresult5);
              $row5 = mysqli_fetch_assoc($queryr5);
              $final5=implode($row5);
              //echo $final5.",";
            
              //65 fetch
            $sqlresult6 = "SELECT correct FROM questionchoices WHERE choices='$q6'AND questionID=6;";
              $queryr6 = mysqli_query($conn,$sqlresult6);
              $row6 = mysqli_fetch_assoc($queryr6);
              $final6=implode($row6);
              //echo $final6.",";
            
              //q7 fetch
            $sqlresult7 = "SELECT correct FROM questionchoices WHERE choices='$q7'AND questionID=7;";
              $queryr7 = mysqli_query($conn,$sqlresult7);
              $row7 = mysqli_fetch_assoc($queryr7);
              $final7=implode($row7);
              //echo $final7.",";
            
              //q8 fetch
            $sqlresult8 = "SELECT correct FROM questionchoices WHERE choices='$q8'AND questionID=8;";
              $queryr8 = mysqli_query($conn,$sqlresult8);
              $row5 = mysqli_fetch_assoc($queryr8);
              $final8=implode($row5);
              //echo $final8.",";
              //q9 fetch
              $sqlresult9 = "SELECT correct FROM questionchoices WHERE choices='$q9'AND questionID=9;";
              $queryr9 = mysqli_query($conn,$sqlresult9);
              $row5 = mysqli_fetch_assoc($queryr9);
              $final9=implode($row5);
              //echo $final9.",";
              //q10 fetch
              $sqlresult10 = "SELECT correct FROM questionchoices WHERE choices='$q10'AND questionID=10;";
              $queryr10 = mysqli_query($conn,$sqlresult10);
              $row5 = mysqli_fetch_assoc($queryr10);
              $final10=implode($row5);
              //echo $final10.",";
              //q11 fetch
              $sqlresult11 = "SELECT correct FROM questionchoices WHERE choices='$q11'AND questionID=11;";
              $queryr11 = mysqli_query($conn,$sqlresult11);
              $row5 = mysqli_fetch_assoc($queryr11);
              $final11=implode($row5);
              //echo $final11.",";
              //q12 fetch
              $sqlresult12 = "SELECT correct FROM questionchoices WHERE choices='$q12'AND questionID=12;";
              $queryr12 = mysqli_query($conn,$sqlresult12);
              $row5 = mysqli_fetch_assoc($queryr12);
              $final12=implode($row5);
              //echo $final12.",";
              //q13 fetch
              $sqlresult13 = "SELECT correct FROM questionchoices WHERE choices='$q13'AND questionID=13;";
              $queryr13 = mysqli_query($conn,$sqlresult13);
              $row5 = mysqli_fetch_assoc($queryr13);
              $final13=implode($row5);
              //echo $final13.",";
              //q14 fetch
              $sqlresult14 = "SELECT correct FROM questionchoices WHERE choices='$q14' AND questionID=14;";
              $queryr14 = mysqli_query($conn,$sqlresult14);
              $row5 = mysqli_fetch_assoc($queryr14);
              $final14=implode($row5);
              //echo $final14.",";
              //q15 fetch
              $sqlresult15 = "SELECT correct FROM questionchoices WHERE choices='$q15'AND questionID=15;";
              $queryr15 = mysqli_query($conn,$sqlresult15);
              $row5 = mysqli_fetch_assoc($queryr15);
              $final15=implode($row5);
              //echo $final15;
              //echo $final15;
            
              // kung lahat ng sagot "coorect" = "1", "qualified" ang ilalagay sa table na applicationresult_tbl, pero pag kahit isa lang sa sagot may 0 "Not Qualified" ang malalagay. Default na rin yung "pending" sa result status.
            if ($ffinal1=="1" && $final2=="1"){
              if ($final3=="1" && $final4=="1"){
                if ($final5=="1" && $final6=="1"){
                  if ($final7=="1" && $final8=="1"){
                    if ($final9=="1" && $final10=="1"){
                      if ($final11=="1" && $final2=="1"){
                        if ($final13=="1" && $final14=="1"){
                          if ($final15=="1"){
                            $row5 = "INSERT INTO applicationresult_tbl (application_id,application_result,application_status)
                            VALUES ('$final1','Qualified','Pending');";
                            $query5 = mysqli_query($conn,$row5); 
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

            else 
              {
                $row5 = "INSERT INTO applicationresult_tbl (application_id,application_result,application_status)                
                VALUES ('$final1','Not Qualified','Pending');";
                $query5 = mysqli_query($conn,$row5);                 
              } 
                                              
        }
  }
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

                <!-- ADOPT ME! - trigger ng application form pop up-->
                <?php
                $disable = "SELECT adopter_id, application_status from applicationform1, applicationresult_tbl WHERE applicationform1.adopter_id='$adopter_id';";
                $qdisable = mysqli_query($conn,$disable);
                ?>
                  <button type="button"  class="btn btn-primary btn-lg show-modal" data-toggle="modal" data-target="#myModal"
                      <?php 
                      if ($qdisable->num_rows!=0){
                              $fdisable = mysqli_fetch_assoc($qdisable);
                                if ($fdisable['application_status'] == "Pending"){ 
                                
                                  ?> disabled 
                                    <?php 
                                }
                              }
                                    ?> 
                  >
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
                                <p class="description"> Please make sure all details below are correct. Thank you!</p>
                                
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


                                <div class="form-group checkbox">
                                  <span class="input-icon"><i class="fa fa-phone"></i></span>
                                  <input type="text" name="number" class="form-control" value="<?php echo $row['adopter_cnum']; ?>" disabled> 
                                </div>

                                <div class="form-group checkbox">
                                  <span class="input-icon"><i class="fa fa-at"></i></span>
                                  <input type="email" name="email" class="form-control" value="<?php echo $row1['user_email']; ?>" disabled> 
                                </div>

                                <div class="form-group">
                                  <h6> Please choose the address where the pet will reside </hg>
                                </div>
                               
                                <div class="form-group">
                                  <input type="radio" name="address" id="address" value="<?php echo $row['adopter_currentadd']; ?>"><?php echo $row['adopter_currentadd']; ?></input>
                                </div>

                                <div class="form-group">
                                  <input type="radio" name="address" id="address" value="<?php echo $row['adopter_permanentadd']; ?>" required><?php echo $row['adopter_permanentadd']; ?></input>
                                </div>
                                

                                  <h6 style="color:orange;" ><i>*** All fields below are required. *** </i></h6>


                                  <!--Valid ID Picture-->
                                
                                <label>Please upload your Valid ID here for verification purposes:</label>
                                <div class="form-group">
                                  <input class="form-control" type="file" name="valid_id" id="valid_id" required>
                                </div>
                                
                              
                  
                                  <!-- QUESTIONAIRRE -->
                                  

                                <!-- q1: Occupation -->
                                <div class="form-group checkbox">
                                  <label>
                                    <!-- display ONLY q1 record (appplicationquestion table) from database-->
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '1'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*". $question['questions'];?></b>
                                  </label><br>
                                                <!-- Radio Button Start: q1 - OCCUPATION -->
                                  <label>  
                                       <?php
                                          $sql1 = "SELECT choices from questionchoices where questionID = 1;";
                                          $data1 = mysqli_query($conn,$sql1);
                                          while($row1 = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='occupation' value = "<?php echo $row1['choices']?>" required> <?php echo $row1['choices']?> </input><br>
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
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '2'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q2 - civilstatus -->
                                    <label>  
                                       <?php
                                          $sql2 = "SELECT choices from questionchoices where questionID = 2;";
                                          $data2 = mysqli_query($conn,$sql2);
                                          while($row2 = mysqli_fetch_assoc($data2)){
                                            ?>
                                              <input type="radio" name='civilstatus' value = "<?php echo $row2['choices']?>" required> <?php echo $row2['choices']?> </input><br>
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
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '3';" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q3 - CHILDREN -->
                                      <label>  
                                       <?php
                                          $sql3 = "SELECT choices from questionchoices where questionID = 3";
                                          $data3 = mysqli_query($conn,$sql3);
                                          while($row3 = mysqli_fetch_assoc($data3)){
                                            ?>
                                              <input type="radio" name='children' value = "<?php echo $row3['choices']?>" required> <?php echo $row3['choices']?> </input><br>
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
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '4'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q4 - PETS -->
                                    <label>  
                                       <?php
                                          $sql4 = "SELECT choices from questionchoices WHERE questionID=4 ;";
                                          $data4 = mysqli_query($conn,$sql4);
                                          while($row4 = mysqli_fetch_assoc($data4)){
                                            ?>
                                              <input type="radio" name='pets' value = "<?php echo $row4['choices']?>" required> <?php echo $row4['choices']?> </input><br>
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
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '5'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                                              <!-- Radio Button Start: q5 - PASTPETS -->
                                    <label>  
                                       <?php
                                          $sql5 = "SELECT choices from questionchoices where questionID = 5";
                                          $data5 = mysqli_query($conn,$sql5);
                                          while($row5 = mysqli_fetch_assoc($data5)){
                                            ?>
                                              <input type="radio" name='pastpets' value = "<?php echo $row5['choices']?>" required> <?php echo $row5['choices']?> </input><br>
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
                                    <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '6'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                                              <!-- Radio Button Start: q6 - HOUSING -->
                                    <label>  
                                       <?php
                                          $sql6 = "SELECT choices from questionchoices where questionID = 6";
                                          $data6 = mysqli_query($conn,$sql6);
                                          while($row6 = mysqli_fetch_assoc($data6)){
                                            ?>
                                              <input type="radio" name='housing' value = "<?php echo $row6['choices']?>" required> <?php echo $row6['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '7'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions']; ?></b>
                                    </label><br>
                                                <!-- Radio Button Start: q7 - ALLERGY-->
                                    <label>  
                                       <?php
                                          $sql7 = "SELECT choices from questionchoices where questionID = 7";
                                          $data7 = mysqli_query($conn,$sql7);
                                          while($row7 = mysqli_fetch_assoc($data7)){
                                            ?>
                                              <input type="radio" name='allergy' value = "<?php echo $row7['choices']?>" required> <?php echo $row7['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '8'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                      
                                                       <!-- Radio Button Start: q7 - WELLNESS -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '8'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='wellness' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                   <!-- END: q8 -->
                            
                                  <!-- q9: in charge financially -->
                                  <div class="form-group checkbox">
                                    <label>
                                    <!-- display ONLY q9 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '9'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q9 - FINANCE -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '9'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='finance' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '10'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q10 - VACATION -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '10'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='emergency' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '11'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                            
                                              <!-- Radio Button Start: q11 - ALONE -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '11'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='alone' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '12'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                            
                                                <!-- Radio Button Start: q12 - SUPPORT -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '12'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='support' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '13'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                            
                                          <!-- Radio Button Start: q13 - RENT -->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '13'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='rent' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
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
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '14'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>
                            
                                            <!-- Radio Button Start: q14 - ALLOW -->

                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '14'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='allow' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label><br>
                                  </div>
                                <!-- END q14 -->
                            
                                <!-- q15:spending -->
                                  <div class="form-group checkbox">
                                    <label>
                                      <!-- display ONLY q15 record (appplicationquestion table) from database-->
                                      <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '15'" ; $result = $conn->query($sql); $question = $result->fetch_assoc(); echo "*".$question['questions'];?></b>
                                    </label><br>                          
                                            <!-- Input Type Radio Button name: spending-->
                                    <label>  
                                       <?php
                                          $sql = "SELECT * from questionchoices where questionID = '15'";
                                          $data1 = mysqli_query($conn,$sql);
                                          while($row = mysqli_fetch_assoc($data1)){
                                            ?>
                                              <input type="radio" name='spending' value = "<?php echo $row['choices']?>" required> <?php echo $row['choices']?> </input><br>
                                            <?php
                                              }
                                            ?> 
                                    </label>
                                  </div>
                                <!-- END q15-->
                                  
                                <input class = "btn" type="reset">
                                <button class="btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span> Cancel </button>
                                <input class = "btn" type="submit" id="submit" name="submit" value="submit" 
                                
                                onclick="return confirm('Are you sure you want to proceed?')"/>
                              </div>
                              
                              </form>
                          </div>
                          
                        </div>
                      </div>
                     
          </div>
      </div>
    </div>
  </div>
  <?php if (count($_POST)>0) {
    echo '<script>alert("Your application has been submitted! ")</script>';
  }
  ?>
  
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