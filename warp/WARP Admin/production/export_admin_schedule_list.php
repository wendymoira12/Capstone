<?php
include 'config/database.php';
session_start();


if(isset($_POST['export'], $_SESSION['start_date'], $_SESSION['end_date'])){
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_schedule_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Scheduled Date', 'Adopter First Name', 'Adopter Last Name','City', 'Adoptee'));
    $sql1 = "SELECT schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE (schedule_tbl.schedule_date BETWEEN '$start_date' and '$end_date')";
    $result1 = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        fputcsv($output, $row1);
    }
    fclose($output);
    unset($_SESSION['start_date'], $_SESSION['end_date']);
} else if(isset($_POST['export'], $_SESSION['city'])){
    $city_id = $_SESSION['city'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_schedule_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Scheduled Date', 'Adopter First Name', 'Adopter Last Name','City', 'Adoptee'));
    $sql2 = "SELECT schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$city_id'";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        fputcsv($output, $row2);
    }
    fclose($output);
    unset($_SESSION['city']);
} else if(isset($_POST['export'])){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_schedule_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Scheduled Date', 'Adopter First Name', 'Adopter Last Name','City', 'Adoptee'));
    $sql = "SELECT schedule_tbl.schedule_date, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name FROM schedule_tbl INNER JOIN applicationform1 ON schedule_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
} else {
    echo "<script>alert('Something went wrong.')</script>";
}

?>