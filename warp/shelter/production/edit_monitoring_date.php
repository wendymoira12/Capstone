<?php
session_start();
include 'config.php';
//Form Submission for date
if (isset($_GET['adopted_id']) && isset($_POST['submit-date'])) {
    $date = $_POST['date'];
    $adopted_id = $_GET['adopted_id'];
    //If date is not empty code will execute
    if (!empty($date)) {
        $sql = "UPDATE adopted_tbl SET monitoring_date = ? WHERE adopted_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si", $date, $adopted_id);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Successfully changed monitoring date')</script>";
            echo "<script>window.location.href='shelter_adopted_list.php';</script>";
        }
    } else {
        echo "<script>alert('No date input')</script>";
    }
} 


if (isset($_POST['cancel'])) {
    header('Location:shelter_adopted_list.php');
}
?>