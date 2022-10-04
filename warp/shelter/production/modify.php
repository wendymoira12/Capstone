<!-- MODIFY DATABASE BASED ON SHELTER_ADOPTEE_EDIT.PHP -->
<?php 

    include 'config.php';

    if (isset($_GET['id']) && isset($_POST['edit-pet-submit']))
    {
        $id = $_GET['id'];
        $pet_name = $_POST['pet-name'];
        $pet_age = $_POST['pet-age'];
        $color = $_POST['color'];
        $specie = $_POST['specie'];
        $gender = $_POST['gender'];
        $neuter = $_POST['neuter'];
        $vaccine = $_POST['vaccine'];
        $size = $_POST['size'];
        $medrec = $_POST['medrec'];
        $sociability = $_POST['sociability'];
        $energy = $_POST['energy'];
        $affection = $_POST['affection'];

        $pet_img = $_FILES['pet-img']['name'];
        $pet_img_tmp_name = $_FILES['pet-img']['tmp_name'];
        $pet_img_folder = 'images/' . $pet_img;

        $pet_vid = $_FILES['pet-vid']['name'];
        $pet_vid_tmp_name = $_FILES['pet-vid']['tmp_name'];
        $pet_vid_folder = 'images/' . $pet_vid;

        if (!empty($pet_name) && !empty($pet_age) && !empty($color) && !empty($specie) && !empty($gender) && !empty($neuter) && !empty($vaccine) && !empty($size) && !empty($medrec) && !empty($sociability) && !empty($energy) && !empty($affection) && !empty($pet_img) && !empty($pet_vid))
        {

            $sql = "UPDATE adoptee_tbl SET pet_name = '$pet_name', pet_age = '$pet_age', pet_color = '$color', pet_specie = '$specie', pet_gender = '$gender', pet_neuter = '$neuter', pet_vax = '$vaccine', pet_size = '$size', pet_medrec = '$medrec', pet_lsoc = '$sociability', pet_lene = '$energy', pet_laff = '$affection', pet_img = '$pet_img', pet_vid = '$pet_vid' WHERE pet_id = '$id'";

            $result = $conn->query($sql);

            if ($result == true)
            {
                echo "Database updated";
            }else
            {
                echo "Connection Failed";
            }
        }else
        {
            echo "All fields must be filled out";
        }
    }else
    {
        echo "Id is invalid";
    }

?>