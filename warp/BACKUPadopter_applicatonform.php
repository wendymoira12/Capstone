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
          $disable = "SELECT adopter_id, application_status from applicationform1, applicationresult_tbl WHERE applicationform1.adopter_id='$adopter_id' ORDER BY applicationresult_tbl.application_id DESC;";
          $qdisable = mysqli_query($conn, $disable);
          ?>
          <button type="button" class="btn btn-primary btn-lg show-modal" data-toggle="modal" data-target="#myModal" <?php
            if ($qdisable->num_rows != 0) {
            $fdisable = mysqli_fetch_assoc($qdisable);
            if ($fdisable['application_status'] == "Pending") {
              ?> disabled <?php
                }
                }
         ?>>
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


                    <h6 style="color:orange;"><i>*** All fields below are required. *** </i></h6>


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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '1'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>
                      <!-- Radio Button Start: q1 - OCCUPATION -->
                      <label>
                        <?php
                        $sql1 = "SELECT choices from questionchoices where questionID = 1;";
                        $data1 = mysqli_query($conn, $sql1);
                        while ($row1 = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='occupation' value="<?php echo $row1['choices'] ?>" required> <?php echo $row1['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '2'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q2 - civilstatus -->
                      <label>
                        <?php
                        $sql2 = "SELECT choices from questionchoices where questionID = 2;";
                        $data2 = mysqli_query($conn, $sql2);
                        while ($row2 = mysqli_fetch_assoc($data2)) {
                        ?>
                          <input type="radio" name='civilstatus' value="<?php echo $row2['choices'] ?>" required> <?php echo $row2['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '3';";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q3 - CHILDREN -->
                      <label>
                        <?php
                        $sql3 = "SELECT choices from questionchoices where questionID = 3";
                        $data3 = mysqli_query($conn, $sql3);
                        while ($row3 = mysqli_fetch_assoc($data3)) {
                        ?>
                          <input type="radio" name='children' value="<?php echo $row3['choices'] ?>" required> <?php echo $row3['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '4'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q4 - PETS -->
                      <label>
                        <?php
                        $sql4 = "SELECT choices from questionchoices WHERE questionID=4 ;";
                        $data4 = mysqli_query($conn, $sql4);
                        while ($row4 = mysqli_fetch_assoc($data4)) {
                        ?>
                          <input type="radio" name='pets' value="<?php echo $row4['choices'] ?>" required> <?php echo $row4['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '5'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q5 - PASTPETS -->
                      <label>
                        <?php
                        $sql5 = "SELECT choices from questionchoices where questionID = 5";
                        $data5 = mysqli_query($conn, $sql5);
                        while ($row5 = mysqli_fetch_assoc($data5)) {
                        ?>
                          <input type="radio" name='pastpets' value="<?php echo $row5['choices'] ?>" required> <?php echo $row5['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '6'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>
                      <!-- Radio Button Start: q6 - HOUSING -->
                      <label>
                        <?php
                        $sql6 = "SELECT choices from questionchoices where questionID = 6";
                        $data6 = mysqli_query($conn, $sql6);
                        while ($row6 = mysqli_fetch_assoc($data6)) {
                        ?>
                          <input type="radio" name='housing' value="<?php echo $row6['choices'] ?>" required> <?php echo $row6['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '7'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>
                      <!-- Radio Button Start: q7 - ALLERGY-->
                      <label>
                        <?php
                        $sql7 = "SELECT choices from questionchoices where questionID = 7";
                        $data7 = mysqli_query($conn, $sql7);
                        while ($row7 = mysqli_fetch_assoc($data7)) {
                        ?>
                          <input type="radio" name='allergy' value="<?php echo $row7['choices'] ?>" required> <?php echo $row7['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '8'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q7 - WELLNESS -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '8'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='wellness' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '9'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>


                      <!-- Radio Button Start: q9 - FINANCE -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '9'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='finance' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '10'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>


                      <!-- Radio Button Start: q10 - VACATION -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '10'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='emergency' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '11'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>


                      <!-- Radio Button Start: q11 - ALONE -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '11'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='alone' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '12'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>


                      <!-- Radio Button Start: q12 - SUPPORT -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '12'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='support' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '13'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>


                      <!-- Radio Button Start: q13 - RENT -->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '13'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='rent' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '14'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>

                      <!-- Radio Button Start: q14 - ALLOW -->

                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '14'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='allow' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
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
                        <b><?php $sql = "SELECT * FROM applicationquestions where questionID = '15'";
                            $result = $conn->query($sql);
                            $question = $result->fetch_assoc();
                            echo "*" . $question['questions']; ?></b>
                      </label><br>
                      <!-- Input Type Radio Button name: spending-->
                      <label>
                        <?php
                        $sql = "SELECT * from questionchoices where questionID = '15'";
                        $data1 = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data1)) {
                        ?>
                          <input type="radio" name='spending' value="<?php echo $row['choices'] ?>" required> <?php echo $row['choices'] ?> </input><br>
                        <?php
                        }
                        ?>
                      </label>
                    </div>
                    <!-- END q15-->

                    <input class="btn" type="reset">
                    <button class="btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span> Cancel </button>
                    <input class="btn" type="submit" id="submit" name="submit" value="submit" onclick="return confirm('Are you sure you want to proceed?')" />
                </div>

                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php if (count($_POST) > 0) {
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