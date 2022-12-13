<?php
session_start();
include 'config.php';
//Form Submission for date
if (isset($_GET['sched_id']) && isset($_POST['submit-date'])) {
    $date = $_POST['date'];
    $id = $_GET['sched_id'];
    //If date is not empty code will execute
    if (!empty($date)) {
        $sql = "UPDATE schedule_tbl SET schedule_date = ? WHERE schedule_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si", $date, $id);
            mysqli_stmt_execute($stmt);
            $sql2 = "SELECT application_id FROM schedule_tbl WHERE schedule_id = '$id'";
            $result = mysqli_query($conn, $sql2);
            if ($result->num_rows > 0) {
                $data = mysqli_fetch_assoc($result);
                $app_id = $data['application_id'];
                $change = '2';
                //notif para sa pagaccept ng application form
                $msg = 'This shelter has changed your interview date for pet '; //message if ever na papalitan ni shelter yung interview date ni adopter
                $sql_insert = "INSERT INTO adopternotif_tbl(application_id, schedule_id,  message, isAccepted) VALUES('$app_id', '$id', '$msg', '$change')"; //Di ko alam pano ipapasok yung user_id para ma specify kung para kaninong adopter lang lalabas yung notif

                if (mysqli_query($conn, $sql_insert)) {
                    //unset($_SESSION['app_id'], $_SESSION['sched_id']);
                    echo "<script>alert('Successfully changed schedule date')</script>";
                    echo "<script>window.location.href='shelter_schedule_list.php';</script>";
                } else {
                    echo mysqli_error($conn);
                    exit;
                }
            }
        }
    } else {
        echo "<script>alert('No date input')</script>";
    }
}

if (isset($_POST['cancel'])) {
    header('Location:shelter_schedule_list.php');
}
