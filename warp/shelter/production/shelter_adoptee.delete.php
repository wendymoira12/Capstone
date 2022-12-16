<?php 

    include 'config.php';

    if(isset($_GET['id']))
    {

        $id = $_GET['id'];
        $sql = "DELETE FROM adoptee_tbl WHERE pet_id = '$id'";

        if ($conn->query($sql) == true)
            {
                echo "Adoptee deleted successfully";
                echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
            }else
            {
                echo "Something went wrong";
                echo "<script>window.location.href='shelter_adoptee_list.php';</script>";
            }

    }else
    {
        die('Id not provided');
    }

?>