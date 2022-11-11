<!-- MODIFY DATABASE BASED ON SHELTER_ADOPTEE_EDIT.PHP -->
<?php

session_start();
include 'config.php';

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

if (isset($_GET['city_id']) && isset($_POST['edit-shelter-submit'])) {
    $id = $_GET['city_id'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $about = $_POST['about'];

    $img = $_FILES['logo']['name'];
    $img_tmp_name = $_FILES['logo']['tmp_name'];
    $img_folder = '../../../../images/logo/' . $img;


    if (!empty($city) && !empty($contact) && !empty($about) && !empty($img)) {

        $sql = "UPDATE city_tbl SET city_name = '$city', city_contact = '$contact', city_about = '$about', city_img = '$img' WHERE city_id = '$id'";

        $result = $conn->query($sql);

        if ($result == true) {
            echo "Database updated";
            header('Location: shelter_account.php');
        } else {
            echo "Connection Failed";
        }
    } else {
        echo "All fields must be filled out";
    }
} else {
    echo "Id is invalid";
}

// UPLOAD THE IMAGES IN THE IMAGES FOLDER
if ($result) {
    move_uploaded_file($img_tmp_name, $img_folder);

    echo "<script>alert('Shelter updated successfully')</script>";
    header("Location: shelter_account.php");
  } else {
    echo "<script>alert('Oops! Something went wrong')</script>";
    header("Location: shelter_account.php");
  }

?>