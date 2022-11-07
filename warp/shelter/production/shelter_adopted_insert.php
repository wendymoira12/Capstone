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
        $datetoday = date_add(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("30 days"));
        $monitoring_date = date_format($datetoday, "Y-m-d H:i:s");

        $sql2 = "INSERT INTO adopted_tbl(application_id, monitoring_date) VALUES ('$application_id', '$monitoring_date')";
        $result = mysqli_query($conn, $sql2);
        if ($result == 1) {
            //Query will be the updating status of application status after this query proceed to next query
            $status = 'Finished';
            $sql3 = "UPDATE applicationresult_tbl SET application_status='$status' WHERE application_id = '$application_id'";
            $result = mysqli_query($conn, $sql3);
            header('Location:shelter_adopted_list.php');
            // NO DELETION YET
            /* 
            if ($result == 1) {
                //Query will be the deletion of schedule from schedule tbl and Pet Adoptee list
            } 
            */
        }
    }

    //Monitoring algorithm
}
