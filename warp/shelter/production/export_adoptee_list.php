<?php
include 'config.php';
session_start();


// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];
// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $city_id = $row['city_id'];
    $sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
    $result = mysqli_query($conn, $sql);
    if ($result == TRUE) {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['export'], $_SESSION['start_date'], $_SESSION['end_date'])) {
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql1 = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl WHERE (created_at BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
    $result1 = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        fputcsv($output, $row1);
    }
    fclose($output);
    unset($_SESSION['start_date'], $_SESSION['end_date']);
} else if (isset($_POST['export'], $_SESSION['specie'])) {
    $specie = $_SESSION['specie'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql2 = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl WHERE adoptee_tbl.pet_specie = '$specie' AND adoptee_tbl.city_id = '$city_id'";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        fputcsv($output, $row2);
    }
    fclose($output);
    unset($_SESSION['specie']);
} else if (isset($_POST['export'], $_SESSION['gender'])) {
    $gender = $_SESSION['gender'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql3 = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl  WHERE adoptee_tbl.pet_gender = '$gender' AND adoptee_tbl.city_id = '$city_id'";
    $result3 = mysqli_query($conn, $sql3);
    while ($row3 = mysqli_fetch_assoc($result3)) {
        fputcsv($output, $row3);
    }
    fclose($output);
    unset($_SESSION['gender']);
} else if (isset($_POST['export'], $_SESSION['size'])) {
    $size = $_SESSION['size'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql4 = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl  WHERE adoptee_tbl.pet_size = '$size' AND adoptee_tbl.city_id = '$city_id'";
    $result4 = mysqli_query($conn, $sql4);
    while ($row4 = mysqli_fetch_assoc($result4)) {
        fputcsv($output, $row4);
    }
    fclose($output);
    unset($_SESSION['size']);
} else if (isset($_POST['export'], $_SESSION['neuter'])) {
    $neuter = $_SESSION['neuter'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql5 = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl  WHERE adoptee_tbl.pet_neuter = '$neuter' AND adoptee_tbl.city_id = '$city_id'";
    $result5 = mysqli_query($conn, $sql5);
    while ($row5 = mysqli_fetch_assoc($result5)) {
        fputcsv($output, $row5);
    }
    fclose($output);
    unset($_SESSION['neuter']);
}  else if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_adoptee_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Age', 'Color', 'Breed', 'Specie', 'Sex', 'Neuter/Spayed', 'Size', 'Date Created'));
    $sql = "SELECT adoptee_tbl.pet_name, adoptee_tbl.pet_age, adoptee_tbl.pet_color, adoptee_tbl.pet_breed, adoptee_tbl.pet_specie, adoptee_tbl.pet_gender, adoptee_tbl.pet_neuter, adoptee_tbl.pet_size, adoptee_tbl.created_at FROM adoptee_tbl WHERE adoptee_tbl.city_id = '$city_id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
} else {
    echo "<script>alert('Something went wrong.')</script>";
}
