<?php session_start(); ?>
<?php include 'config.php'; 


?>
<?php 

if (isset($_POST['submit']))
    {
  $user_id = $_SESSION['user_id'];
  $valid_id = $_FILES['valid_id'];
  $valid_id_folder = 'images/valid_id/' . $valid_id;
  $valid_id_tmp_name = $_FILES['valid_id']['tmp_name'];


  $occupation= $_POST['occupation'];
  $civilstatus = $_POST['civilstatus'];
  $children = $_POST['children'];
  $pets = $_POST['pets'];
  $pastpets = $_POST['pastpets'];
  $housing = $_POST['housing'];
  $allergy = $_POST['allergy'];
  $wellness = $_POST['wellness'];
  $finance = $_POST['finance'];
  $emergency = $_POST['emergency'];
  $alone = $_POST['alone'];
  $support = $_POST['support'];
  $rent = $_POST['rent'];
  $allow = $_POST['allow'];
  $spending = $_POST['spending'];

  $row = "INSERT INTO applicationform1 (valid_id,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15) VALUES ('$valid_id','$occupation','$civilstatus','$children','$pets','$pastpets','$housing','$allergy','$wellness','$finance','$emergency','$alone','$support','$rent','$allow','$spending');";
  $query3 = mysqli_query($conn,$row);
    }
header("location: AdopteePage.php?id=1");
?>