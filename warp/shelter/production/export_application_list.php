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

if (isset($_POST['export'], $_SESSION['result'])) {
    $appli_result = $_SESSION['result'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id' AND applicationresult_tbl.application_result = '$appli_result'";
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
    header('Content-Disposition:attachment; filename=report_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql1 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE (applicationform1.date_submitted BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
    $result1 = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        fputcsv($output, $row1);
    }
    fclose($output);
    unset($_SESSION['start_date'], $_SESSION['end_date']);
} else if (isset($_POST['export'], $_SESSION['status'])) {
    $appli_status = $_SESSION['status'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql2 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id' AND applicationresult_tbl.application_status = '$appli_status'";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        fputcsv($output, $row2);
    }
    fclose($output);
    unset($_SESSION['status']);
} else if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=report_application_list.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Adopter First Name', 'Adopter Last Name', 'Adoptee', 'Date Submitted', 'System Assessment', 'Application Status', 'Accepted By'));
    $sql4 = "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_name, applicationform1.date_submitted, applicationresult_tbl.application_result, applicationresult_tbl.application_status, applicationresult_tbl.acceptedby_name  FROM applicationform1 INNER JOIN applicationresult_tbl ON applicationform1.application_id = applicationresult_tbl.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id WHERE adoptee_tbl.city_id = '$city_id'";
    $result4 = mysqli_query($conn, $sql4);
    while ($row4 = mysqli_fetch_assoc($result4)) {
        fputcsv($output, $row4);
    }
    fclose($output);
} else {
    echo "<script>alert('Something went wrong.')</script>";
}
