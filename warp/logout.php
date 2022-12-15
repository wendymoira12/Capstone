<?php
    //Logout Module
    session_start();
    if (isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location: index.php");
    } 
    else{
        header("Location: index.php");
    }
?>
