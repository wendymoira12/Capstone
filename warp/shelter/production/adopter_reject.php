<?php
include 'config.php';
session_start();


  // Pag naclick si cancel button, mapapalitan yung application status sa application list

    if(isset($_POST['cancel'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM applicationresult_tbl INNER JOIN applicationform1 ON applicationresult_tbl.application_id = applicationform1.application_id WHERE applicationresult_tbl.application_id = applicationform1.application_id = '$id'";
        $result = $conn->query($sql);

        if($result == TRUE){
            $cancel = 'Cancelled by adopter';
            $sql = "UPDATE applicationresult_tbl SET application_status='$cancel' WHERE application_id = '$id'";
            $result = $conn->query($sql);
            if($result){
                header('Location:adopter_user_page.php');
        }
        }
    }

?>