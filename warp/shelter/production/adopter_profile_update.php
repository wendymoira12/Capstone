<!-- MODIFY DATABASE BASED ON SHELTER_ADOPTEE_EDIT.PHP -->
<?php

session_start();
include 'config.php';

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
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
$sql = "SELECT * FROM adopter_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $adopter_id = $row['adopter_id'];
}
?>
<?php

if (isset($_POST['submit'])) {
    $adopter_pfp = mysqli_real_escape_string($conn, $_FILES['adopter_pfp']['tmp_name']);
    $adopter_img_tmp_name = $_FILES['adopter_pfp']['tmp_name'];
    // upload image to folder named images/
    $adopter_img_folder = '/images/adopter_pfp/' . $adopter_pfp;
    // only images can be uploaded
    $adopter_img_imagetype = exif_imagetype($adopter_img_tmp_name);
    if(!$adopter_img_imagetype) {
      echo('Uploaded file is not an image.');
    }
  

    //extension nung file dapat JPEG PNG GIF XBM XPM WBMP WebP BMP
    $image_extension = image_type_to_extension($adopter_img_imagetype, true);
  
    //converts image name into hexadecimal
    $image_name = bin2hex(random_bytes(16)) . $image_extension;
  
    if (!empty($adopter_pfp)) {

        $sql = "UPDATE adopter_tbl SET adopter_pfp = '$image_name' WHERE adopter_id = '$adopter_id";

        $result = $conn->query($sql);

        if ($result == true) {
            echo "Database updated";
            header('Location: adopter_user_page.php');
        } else {
            echo "Connection Failed";
        }
    } 
} else {
    echo "Id is invalid";
}

// UPLOAD THE IMAGES AND VIDEOS IN THE IMAGES FOLDER
if ($result) {
    move_uploaded_file($adopter_img_tmp_name, __DIR__ . "/shelter/production/images/adopter_pic/" . $image_name);

    echo "<script>alert('Adoptee added successfully')</script>";
    header("Location: adopter_user_page.php");
  } else {
    echo "<script>alert('Oops! Something went wrong')</script>";
    header("Location: adopter_user_page.php");
  }

?>