<?php
include 'config/database.php';
session_start();


if (isset($_POST['export'], $_SESSION['result'])) {
    $appli_result = $_SESSION['result'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'City', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE applicationresult_tbl.application_result = '$appli_result'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    unset($_SESSION['result']);
} else if (isset($_POST['export'], $_SESSION['start_date'], $_SESSION['end_date'])) {
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'City', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql1 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE (applicationform1.date_submitted BETWEEN '$start_date' and '$end_date')";
    $result1 = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        fputcsv($output, $row1);
    }
    fclose($output);
    unset($_SESSION['start_date'], $_SESSION['end_date']);
} else if (isset($_POST['export'], $_SESSION['status'])) {
    $appli_status = $_SESSION['status'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'City', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql2 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE applicationresult_tbl.application_status = '$appli_status'";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        fputcsv($output, $row2);
    }
    fclose($output);
    unset($_SESSION['status']);
} else if (isset($_POST['export'], $_SESSION['city'])) {
    $city_id = $_SESSION['city'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'City', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql3 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$city_id'";
    $result3 = mysqli_query($conn, $sql3);
    while ($row3 = mysqli_fetch_assoc($result3)) {
        fputcsv($output, $row3);
    }
    fclose($output);
    unset($_SESSION['city']);
} else if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_admin_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'City', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql4 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, city_tbl.city_name, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
    $result4 = mysqli_query($conn, $sql4);
    while ($row4 = mysqli_fetch_assoc($result4)) {
        fputcsv($output, $row4);
    }
    fclose($output);
} else {
    echo "<script>alert('Something went wrong.')</script>";
}
