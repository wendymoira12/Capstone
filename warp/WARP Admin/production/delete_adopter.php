<?php
include 'config/database.php';

if (isset($_GET['adopter_id'])) {
    $adopter_id = $_GET['adopter_id'];
    $sql = "UPDATE adopter_tbl SET deleted_at = now() WHERE adopter_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "<script>alert('SQL Prepared Statement Failed')</script>";
    } else{
        mysqli_stmt_bind_param($stmt, "i", $adopter_id);
        mysqli_stmt_execute($stmt);

        $sql2 ="SELECT user_id FROM adopter_tbl WHERE adopter_id = '$adopter_id'";
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
                header("Location: manage_adopter.php");
                
            }
        }
    }
}