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
    header('Content-Disposition:attachment; filename=report_schedule_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Scheduled Date', 'Adopter First Name', 'Adopter Last Name', 'Adoptee'));
    $sql1 = "SELECT schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE (schedule_tbl.schedule_date BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id ='$city_id'";
    $result1 = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        fputcsv($output, $row1);
    }
    fclose($output);
    unset($_SESSION['start_date'], $_SESSION['end_date']);
} else if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_schedule_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Scheduled Date', 'Adopter First Name', 'Adopter Last Name', 'Adoptee'));
    $sql = "SELECT schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id ='$city_id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
} else {
    echo "<script>alert('Something went wrong.')</script>";
}
