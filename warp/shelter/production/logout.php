<?php
    //Logout Module
    session_start();
    if (isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location:login.php");
    } 
    else{
        header("Location:login.php");
    }
?>
