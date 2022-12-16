<?php
include 'config.php';
session_start();
?>
<?php
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

    if (empty($_POST['city'])) {
        $cityErr = 'City is required';
    } else {
        $city = filter_input(
            INPUT_POST,
            'city',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    if (empty($_POST['contact'])) {
        $contactErr = 'Contact Number is required';
    } else {
        $contact = filter_input(
            INPUT_POST,
            'contact',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    if (empty($_POST['about'])) {
        $aboutErr = 'About is required';
    } else {
        $about = filter_input(
            INPUT_POST,
            'about',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }


    $img = $_FILES['logo']['name'];
    $img_tmp_name = $_FILES['logo']['tmp_name'];
    $img_folder = '/images/logo/' . $img;


    if (empty($cityErr) && empty($contactErr) && empty($aboutErr) && !empty($img)) {

        $sql = "UPDATE city_tbl SET city_name = ?, city_contact = ?, city_about = ?, city_img = ? WHERE city_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL Prepare Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ssssi", $city, $contact, $about, $img, $id);
            mysqli_stmt_execute($stmt);
            move_uploaded_file($img_tmp_name, __DIR__ . $img_folder);
            echo "<script>window.location.href='shelter_account.php';</script>";
        }
    } else {
        echo "All fields must be filled out";
    }
} else {
    echo "Id is invalid";
}
?>