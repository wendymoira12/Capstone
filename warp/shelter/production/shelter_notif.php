<!-- Notification bell -->
<?php

$sql_get = mysqli_query($conn, "SELECT adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, shelternotif_tbl.message, adoptee_tbl.pet_name, shelternotif_tbl.shelternotif_date FROM shelternotif_tbl INNER JOIN applicationform1 ON shelternotif_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE shelternotif_tbl.status = '0' AND applicationform1.application_id = shelternotif_tbl.application_id AND adoptee_tbl.city_id = '$city_id' ORDER BY shelternotif_tbl.shelternotif_date DESC ");
$count = mysqli_num_rows($sql_get);
// $notifdate = mysqli_fetch_assoc($sql_get);
// include "time_ago_shelter.php";

?>

<li role="presentation" class="dropdown">
<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell-o"></i>
    <span class="badge bg-green"><?php echo $count; ?></span>
</a>
<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
    <?php
    if (mysqli_num_rows($sql_get) > 0) {
    while ($notif = mysqli_fetch_assoc($sql_get)) {
    ?>
        <li>
        <a>
            <span class="image"><img src="images/user.png" alt="Profile Image" /></span>
            <span>
            <span style="font-weight: 900;">
                <?php 
                echo $notif['shelternotif_date'];
                // $unixTimestamp = convertToUnixTimestamp($notifAt);
                // echo convertToAgoFormat($unixTimestamp); 
                ?>
                </span><br>
            <span"><?php echo $notif['adopter_fname'] . ' ' . $notif['adopter_lname']; ?></span>
            </span>
            <span class="message">
            <?php echo $notif['message'] . ' ' . $notif['pet_name']; ?>
            </span>
        </a>
        </li>
    <?php
    }
    } else {
    echo '<a > Sorry! No Notifications to show </a>';
    }
    ?>
</ul>
</li>