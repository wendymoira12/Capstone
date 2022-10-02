<?php 

    include 'config.php';

    if(isset($_GET['id']))
    {

        $id = $_GET['id'];
        $sql = "DELETE FROM adoptee_tbl WHERE pet_id = '$id'";

        if ($conn->query($sql) == true)
            {
                echo "Adoptee deleted successfully";
                header('Location: shelter_adoptee_list.php');
            }else
            {
                echo "Something went wrong";
                header('Location: shelter_adoptee_list.php');
            }

    }else
    {
        die('Id not provided');
    }

?>