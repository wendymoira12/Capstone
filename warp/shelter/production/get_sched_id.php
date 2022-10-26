<?php 
session_start();

if (isset($_GET['id'])){
    $_SESSION['sched_id'] = $_GET['id'];
}
?>