<?php

include 'config.php';
session_start();

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
  header('Location:/login.php');
} else {
  $role_id = $_SESSION['user-role-id'];
  if ($role_id == 2) {
    htmlspecialchars($_SERVER['PHP_SELF']);
  } else {
    header('Location:/home.php');
  }
}

if (isset($_GET['id']) && isset($_POST['edit-pet-submit'])) {
  $id = $_GET['id'];
  $pet_name = $_POST['pet-name'];
  $pet_age = $_POST['pet-age'];
  $color = $_POST['color'];
  $breed = $_POST['breed'];
  $specie = $_POST['specie'];
  $gender = $_POST['gender'];
  $neuter = $_POST['neuter'];
  $origin = $_POST['origin'];
  $vaccine = $_POST['vaccine'];
  $chkstr = implode(", ", $vaccine);

  $weight = $_POST['weight'];
  $size = $_POST['size'];
  $medrec = $_POST['medrec'];
  $sociability = $_POST['sociability'];
  $energy = $_POST['energy'];
  $affection = $_POST['affection'];
  $description = $_POST['description'];

  $pet_img1 = $_FILES['pet-img1']['name'];
  $pet_img_tmp_name = $_FILES['pet-img1']['tmp_name'];
  // upload image to folder named images/
  $pet_img_folder = '/images/pet_img1/' . $pet_img1;
  // only images can be uploaded
  // $pet_img_imagetype = exif_imagetype($pet_img_tmp_name);
  // if (!$pet_img_imagetype) {
  //   echo ('Uploaded file is not an image.');
  // }

  $pet_img2 = $_FILES['pet-img2']['name'];
  $pet_img_tmp_name1 = $_FILES['pet-img2']['tmp_name'];
  // upload image to folder named images/
  $pet_img_folder1 = '/images/pet_img2/' . $pet_img2;
  // only images can be uploaded
  // $pet_img_imagetype1 = exif_imagetype($pet_img_tmp_name1);
  // if (!$pet_img_imagetype1) {
  //   echo ('Uploaded file is not an image.');
  // }

  //Check pet_img size
  // if ($_FILES["pet_img"]["size"] > 5000000000) {
  //   echo "Your file is too large, must be less than 5mb";
  // }

  //Check pet_img1 size
  // if ($_FILES["pet_img1"]["size"] > 5000000000) {
  //   echo "Your file is too large, must be less than 5mb";
  // }

  //extension nung file dapat JPEG PNG GIF XBM XPM WBMP WebP BMP
  // $image_extension1 = image_type_to_extension($pet_img_imagetype, true);
  // $image_extension2 = image_type_to_extension($pet_img_imagetype1, true);

  //converts image name into hexadecimal
  // $image_name1 = bin2hex(random_bytes(16)) . $image_extension1;
  // $image_name2 = bin2hex(random_bytes(16)) . $image_extension2;

  $pet_vid = $_FILES['pet-vid']['name'];
  $pet_vid_tmp_name = $_FILES['pet-vid']['tmp_name'];
  // upload video to folder named images/
  $pet_vid_folder = '/images/pet_vid/' . $pet_vid;

  //Check pet_vid size
  // if ($_FILES["pet_vid"]["size"] > 30000000000) {
  //   echo "Your file is too large, must be less than 30mb";
  // }

  if (!empty($pet_name) && !empty($pet_age) && !empty($color) && !empty($breed) && !empty($specie) && !empty($gender) && !empty($neuter) && !empty($origin) && !empty($chkstr) && !empty($weight) && !empty($size) && !empty($medrec) && !empty($sociability) && !empty($energy) && !empty($affection) && !empty($pet_img1) && !empty($pet_img2) && !empty($pet_vid) && !empty($description)) {

    $sql = "UPDATE adoptee_tbl SET pet_name = '$pet_name', pet_age = '$pet_age', pet_color = '$color', pet_breed = '$breed', pet_specie = '$specie', pet_gender = '$gender', pet_neuter = '$neuter', pet_origin = '$origin', pet_vax = '$chkstr', pet_weight = '$weight', pet_size = '$size', pet_medrec = '$medrec', pet_lsoc = '$sociability', pet_lene = '$energy', pet_laff = '$affection', pet_desc = '$description', pet_img1 = '$pet_img1', pet_img2 = '$pet_img2', pet_vid = '$pet_vid' WHERE pet_id = '$id'";

    $result = $conn->query($sql);

    if ($result == true) {
      move_uploaded_file($pet_img_tmp_name, __DIR__ . $pet_img_folder);
      move_uploaded_file($pet_img_tmp_name1, __DIR__ . $pet_img_folder1);
      move_uploaded_file($pet_vid_tmp_name, __DIR__ . $pet_vid_folder);

      echo "<script>alert('Adoptee Updated')</script>";
      echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
    } else {
      echo "<script>alert('Oops! Something went wrong')</script>";
      echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
    }
  } else {
    echo "All fields must be filled out";
  }
} else {
  echo "Id is invalid";
}
?>