<?php

session_start();
include 'config.php';

if (isset($_GET['adopted_id'])) {
    $adopted_id = $_GET['adopted_id'];
    $done = "Done";

    $sql = "SELECT adopted_id FROM adopted_tbl WHERE adopted_id = '$adopted_id'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $sql2 = "UPDATE adopted_tbl SET monitoring_status = ? WHERE adopted_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si", $done, $adopted_id);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Change Monitoring Status Success')</script>";
            echo "<script>window.location.href='shelter_adopted_list.php';</script>";
        }
    } else {
        echo "<script>alert('Record doesn't exist')</script>";
    }
}
