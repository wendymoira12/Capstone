<?php

session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $app_id = $_GET['id'];
    $datetoday = date_add(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("14 days"));
    $sched_date = date_format($datetoday, "Y-m-d H:i:s");

    //Sql query to check if data exist with same applicatin id in sched table
    $sql = "SELECT * FROM schedule_tbl WHERE (application_id = '$app_id' AND deleted_at IS NULL) LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('Record Exists!')</script>";
        echo "<script>window.location.href='shelter_application_list.php';</script>";
    } else {
        $sql2 = "INSERT INTO schedule_tbl(schedule_date, application_id) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si", $sched_date, $app_id);
            mysqli_stmt_execute($stmt);
            $scheduled = 'Scheduled';
            $sql4 = "UPDATE applicationresult_tbl SET application_status= ? WHERE application_id = ?";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql4)) {
                echo "SQL Prepared Statement Failed";
            } else {
                mysqli_stmt_bind_param($stmt2, "si", $scheduled, $app_id);
                mysqli_stmt_execute($stmt2);
                echo "<script>alert('Date Input Success')</script>";
                echo "<script>window.location.href='shelter_schedule_list.php';</script>";
            }
        }
    }
}
