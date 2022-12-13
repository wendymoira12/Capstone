<?php

session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
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
            mysqli_stmt_bind_param($stmt, "si", $sched_date,   $app_id);
            mysqli_stmt_execute($stmt);
            $scheduled = 'Scheduled';
            $sql3 = "SELECT shelteruser_name FROM shelteruser_tbl WHERE user_id = '$user_id'";
            $result2 = mysqli_query($conn, $sql3);
            if ($result2->num_rows > 0) {
                $row = mysqli_fetch_assoc($result2);
                $shelter_name = $row['shelteruser_name'];
                $sql4 = "UPDATE applicationresult_tbl SET application_status= ?, acceptedby_name= ? WHERE application_id = ?";
                $stmt2 = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt2, $sql4)) {
                    echo "SQL Prepared Statement Failed";
                } else {
                    mysqli_stmt_bind_param($stmt2, "ssi", $scheduled, $shelter_name, $app_id);
                    mysqli_stmt_execute($stmt2);
                    //notif para sa pagaccept ng application form
                    $accept = '1';
                    $msg = 'This shelter has accepted your adoptee application for pet'; //message sa notification ng adopter tas concat name ng pet na inadopt niya
                    //$msg1 = 'The scheduled date for your interview is'; //etong message1 naman naka null sya kase optional lang, if ever na nireject yung application form, wala tong laman kase wala namang massched
                    $sql_insert = mysqli_query($conn, "INSERT INTO adopternotif_tbl(application_id,  message, isAccepted) VALUES('$app_id', '$msg', '$accept')");
                    if ($sql_insert) {
                        echo "<script>alert('Successfully accepted adoption')</script>";
                    } else {
                        echo mysqli_error($conn);
                        exit;
                    }
                    echo "<script>window.location.href='shelter_schedule_list.php';</script>";
                }
            }
        }
    }
}
