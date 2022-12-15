<?php

session_start();

//Check if the id is obtain
if (isset($_GET['id'])){
    //Set the role id
    $role_id = $_GET['id'];
    //if the id == 1 go to adopter user page if ==2 go to shelter else go back to guest home page
    if ($role_id == 1){
        header('Location:/Capstone/warp/shelter/production/adopter_user_page.php');
    } elseif ($role_id == 2){
        header('Location:/Capstone/warp/shelter/production/shelter_account.php');
    } else {
        header('Location: index.php');
    }
    //Nice
}