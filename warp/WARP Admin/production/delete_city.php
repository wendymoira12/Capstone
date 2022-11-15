<?php
include 'config/database.php';

if (isset($_GET['city_id'])) {
    $city_id = $_GET['city_id'];
    $sql = "UPDATE city_tbl SET deleted_at = now() WHERE city_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "<script>alert('SQL Prepared Statement Failed')</script>";
    } else{
        mysqli_stmt_bind_param($stmt, "i", $city_id);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Successfully Deleted')</script>";
        header("Location: manage_city.php");
    }
}
