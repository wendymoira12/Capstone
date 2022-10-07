<?php
    //Logout Module
    session_start();
    if (isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location: home-guest.php");
    } 
    else{
        header("Location: home-guest.php");
    }
?>
