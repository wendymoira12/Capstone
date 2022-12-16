<?php
include 'config/database.php';

if (isset($_GET['shelteruser_id'])) {
    $shelteruser_id = $_GET['shelteruser_id'];
    $sql = "UPDATE shelteruser_tbl SET deleted_at = now() WHERE shelteruser_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "<script>alert('SQL Prepared Statement Failed')</script>";
    } else{
        mysqli_stmt_bind_param($stmt, "i", $shelteruser_id);
        mysqli_stmt_execute($stmt);
        $sql2 ="SELECT user_id FROM shelteruser_tbl WHERE shelteruser_id = '$shelteruser_id'";
        if ($result = mysqli_query($conn, $sql2)){
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $sql3 = "UPDATE user_tbl SET deleted_at = now() WHERE user_id = ?";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql3)){
                echo "SQL Prepare Statement Failed";
            } else {
                mysqli_stmt_bind_param($stmt2,"i", $user_id);
                mysqli_stmt_execute($stmt2);
                echo "<script>alert('Successfully Deleted')</script>";
                echo "<script>window.location.href='manage_shelter.php';</script>";
                //header("Location: manage_shelter.php");
            }
        }
    }
}
?>