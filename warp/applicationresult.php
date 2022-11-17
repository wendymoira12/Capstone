<?php 
/*$app2d = "SELECT * from applicationform1 WHERE adopter_id='$adopter_id' ORDER BY application_id DESC;";
$appresult2 = mysqli_query($conn,$app2d);
$row2 = mysqli_fetch_assoc($appresult2);*/

$app1d = "SELECT application_id from applicationform1 WHERE adopter_id='$adopter_id' ORDER BY application_id DESC;";
              $query1d = mysqli_query($conn,$app1d);
              $row1d = mysqli_fetch_assoc($query1d);
              $final1=implode($row1d);
              
              //q1 fetch
              $sqlresult1 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q1 AND questionchoices.questionID=1;";
              $queryr1 = mysqli_query($conn,$sqlresult1);
              $row1 = mysqli_fetch_assoc($queryr1);
              $ffinal1=implode($row1);
              //echo $ffinal1.",";
         
              //q2 fetch
              $sqlresult2 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q2 AND questionchoices.questionID=2;";
              $queryr2 = mysqli_query($conn,$sqlresult2);
              $row2 = mysqli_fetch_assoc($queryr2);
              $final2=implode($row2);
              //echo $final2.",";
            
              //q3 fetch
              $sqlresult3 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q3 AND questionchoices.questionID=3;";
              $queryr3 = mysqli_query($conn,$sqlresult3);
              $row3 = mysqli_fetch_assoc($queryr3);
              $final3=implode($row3);
              //echo $final3.",";
            
              //q4 fetch
              $sqlresult4 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q4 AND questionchoices.questionID=4;";
              $queryr4 = mysqli_query($conn,$sqlresult4);
              $row4 = mysqli_fetch_assoc($queryr4);
              $final4=implode($row4);
              //echo $final4.","; 
            
              //q5 fetch
              $sqlresult5 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q5 AND questionchoices.questionID=5;";
              $queryr5 = mysqli_query($conn,$sqlresult5);
              $row5 = mysqli_fetch_assoc($queryr5);
              $final5=implode($row5);
              //echo $final5.",";
            
              //65 fetch
              $sqlresult6 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q6 AND questionchoices.questionID=6;";
              $queryr6 = mysqli_query($conn,$sqlresult6);
              $row6 = mysqli_fetch_assoc($queryr6);
              $final6=implode($row6);
              //echo $final6.",";
            
              //q7 fetch
              $sqlresult7 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q7 AND questionchoices.questionID=7;";
              $queryr7 = mysqli_query($conn,$sqlresult7);
              $row7 = mysqli_fetch_assoc($queryr7);
              $final7=implode($row7);
              //echo $final7.",";
            
              //q8 fetch
              $sqlresult8 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q8 AND questionchoices.questionID=8;";
              $queryr8 = mysqli_query($conn,$sqlresult8);
              $row8 = mysqli_fetch_assoc($queryr8);
              $final8=implode($row5);
              //echo $final8.",";
              //q9 fetch
              $sqlresult9 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q9 AND questionchoices.questionID=9;";
              $queryr9 = mysqli_query($conn,$sqlresult9);
              $row9 = mysqli_fetch_assoc($queryr9);
              $final9=implode($row5);
              //echo $final9.",";
              //q10 fetch
              $sqlresult10 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q10 AND questionchoices.questionID=10;";
              $queryr10 = mysqli_query($conn,$sqlresult10);
              $row10 = mysqli_fetch_assoc($queryr10);
              $final10=implode($row5);
              //echo $final10.",";
              //q11 fetch
              $sqlresult11 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q11 AND questionchoices.questionID=11;";
              $queryr11 = mysqli_query($conn,$sqlresult11);
              $row11 = mysqli_fetch_assoc($queryr11);
              $final11=implode($row5);
              //echo $final11.",";
              //q12 fetch
              $sqlresult12 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q12 AND questionchoices.questionID=12;";
              $queryr12 = mysqli_query($conn,$sqlresult12);
              $row12 = mysqli_fetch_assoc($queryr12);
              $final12=implode($row5);
              //echo $final12.",";
              //q13 fetch
              $sqlresult13 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q13 AND questionchoices.questionID=13;";
              $queryr13 = mysqli_query($conn,$sqlresult13);
              $row13 = mysqli_fetch_assoc($queryr13);
              $final13=implode($row5);
              //echo $final13.",";
              //q14 fetch
              $sqlresult14 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q14 AND questionchoices.questionID=14;";
              $queryr14 = mysqli_query($conn,$sqlresult14);
              $row14 = mysqli_fetch_assoc($queryr14);
              $final14=implode($row5);
              //echo $final14.",";
              //q15 fetch
              $sqlresult15 = "SELECT correct FROM questionchoices,applicationform1 WHERE questionchoices.choices=applicationform1.q15 AND questionchoices.questionID=15;";
              $queryr15 = mysqli_query($conn,$sqlresult15);
              $row15 = mysqli_fetch_assoc($queryr15);
              $final15=implode($row5);
              //echo $final15;
              //echo $final15; 
              

              // kung lahat ng sagot "coorect" = "1", "qualified" ang ilalagay sa table na applicationresult_tbl, pero pag kahit isa lang sa sagot may 0 "Not Qualified" ang malalagay. Default na rin yung "pending" sa result status.
              if ($ffinal1 == "1" && $final2 == "1") {
                if ($final3 == "1" && $final4 == "1") {
                  if ($final5 == "1" && $final6 == "1") {
                    if ($final7 == "1" && $final8 == "1") {
                      if ($final9 == "1" && $final10 == "1") {
                        if ($final11 == "1" && $final12 == "1") {
                          if ($final13 == "1" && $final14 == "1") {
                            if ($final15 == "1") {
                              $row5 = "INSERT INTO applicationresult_tbl (application_id,application_result,application_status)
                                    VALUES ('$final1','Qualified','Pending');";
                              $query5 = mysqli_query($conn, $row5);
                            }
                          }
                        }
                      }
                    }
                  }
                }
              } else {
                $row5 = "INSERT INTO applicationresult_tbl (application_id,application_result,application_status)                
                        VALUES ('$final1','Not Qualified','Pending');";
                $query5 = mysqli_query($conn, $row5);
              }
?>