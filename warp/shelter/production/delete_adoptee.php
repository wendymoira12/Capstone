<?php
include 'config.php';

if (isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
    $sql = "UPDATE adoptee_tbl SET deleted_at = now() WHERE pet_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "<script>alert('SQL Prepared Statement Failed')</script>";
    } else{
        mysqli_stmt_bind_param($stmt, "i", $pet_id);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Successfully Deleted')</script>";
        header("Location: shelter_adoptee_list.php");
    }
}
