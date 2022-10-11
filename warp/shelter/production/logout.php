<?php
    //Logout Module
    session_start();
    if (isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location: /Capstone/warp/login.php");
    } 
    else{
        header("Location: /Capstone/warp/login.php");
    }
?>
