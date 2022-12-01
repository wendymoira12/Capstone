<?php
session_start();
include 'config.php';
//Check if the id is obtain
if (isset($_GET['id'])) {
    //Store the id for insertion
    $application_id = $_GET['id'];
    //Check if the application_id exists in application list (applicationform1)
    $sql = "SELECT application_id FROM applicationform1 WHERE application_id = '$application_id'";
    $result = mysqli_query($conn, $sql);
    //If true proceed to next step and to the next query
    if ($result->num_rows > 0) {
        //Query will be insertion of data in adopted tbl after this query proceed to next query 
        //NO MONITORING DATE YET and monitoring status default will be not yet monitored
        $datetoday = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("30 days"));
        $monitoring_date = date_format($datetoday, "Y-m-d");

        $sql2 = "INSERT INTO adopted_tbl(application_id, monitoring_date) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "is", $application_id, $monitoring_date);
            mysqli_stmt_execute($stmt);
            //Query will be the updating status of application status after this query proceed to next query
            $status = 'Finished';
            $sql3 = "UPDATE applicationresult_tbl SET application_status='$status' WHERE application_id = '$application_id'";
            if (mysqli_query($conn, $sql3) == 1) {
                $sql4 = "UPDATE schedule_tbl SET deleted_at = now() WHERE application_id ='$application_id'";
                if (mysqli_query($conn, $sql4) == 1) {
                    $sql5 = "UPDATE adoptee_tbl SET deleted_at = now() WHERE pet_id = (SELECT pet_id FROM applicationform1 WHERE application_id = '$application_id')";
                    if (mysqli_query($conn, $sql5)) {
                        header('Location:shelter_adopted_list.php');
                    }
                }
            }
        }
    }

    //Monitoring algorithm
}
