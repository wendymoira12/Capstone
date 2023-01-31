<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['email-login'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            padding-top: 10px;
            position: relative;
            top: 10px;
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            padding-left: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            padding-top: 12px;
            padding-left: 8px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #FF843A;
            color: white;
        }

        header .report_title {
            display: inline-block;
            position: absolute;
            top: 0px;
            left: 230px;
        }

        header .report_filter {
            display: inline-block;
            position: absolute;
            top: 32px;
            left: 230px;
        }

        header .report_time {
            display: inline-block;
            position: absolute;
            top: 23px;
            right: 10px;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0px;
            right: 0px;
            height: 80px;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0px;
            right: 0px;
            height: 30px;
        }

        footer .pagenum:before {
            content: counter(page);
        }

        footer .warp-container {
            text-align: left;
            float: left;
            font-weight: 200;
            color: #FF843A;
        }

        footer .pagenum-container {
            text-align: right;
            float: right;
        }
    </style>

</head>

<body>
    <header>
        <div>
            <img src="sample3.jpg" width="205" height="75">
        </div>
        <div class="report_title">
            <h3>Adopted Pet List</h3>
        </div>
        <div class="report_filter">
            <p>
                <?php
                if (isset($_SESSION['start_date'], $_SESSION['end_date'])) {
                    $start_date = $_SESSION['start_date'];
                    $end_date = $_SESSION['end_date'];
                    echo "Filtered by date adopted from" . " $start_date " . " to " . " $end_date ";
                } else if (isset($_SESSION['monitor_start_date'], $_SESSION['monitor_end_date'])) {
                    $monitor_start_date = $_SESSION['monitor_start_date'];
                    $monitor_end_date = $_SESSION['monitor_end_date'];
                    echo "Filtered by monitoring date from" . " $monitor_start_date " . " to " . " $monitor_end_date ";
                } else if (isset($_SESSION['monitor_status'])) {
                    echo "Monitoring Status";
                } else if (isset($_SESSION['city'])) {
                    echo "Filtered by City";
                } else {
                    echo "No Filter";
                }
                ?>
            </p>
        </div>
        <div class="report_time">
            <?php
            $datetoday = date("m/d/Y");
            echo $datetoday;
            ?>
        </div>
    </header>
    <footer>
        <div class="warp-container">WARP </div>
        <div class="pagenum-container">Page <span class="pagenum"></span></div>
    </footer>

    <main>
        <div class="pdf_content">
            <?php
            if (isset($_SESSION['start_date'], $_SESSION['end_date'])) {
                $i = 1;
                $start_date = $_SESSION['start_date'];
                $end_date = $_SESSION['end_date'];
                $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id, city_tbl.city_name FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adopted_tbl.date_adopted BETWEEN '$start_date' and '$end_date'";
                $result1 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result1) > 0) {
                    $total = mysqli_num_rows($result1);
            ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Adopter Name</th>
                                    <th>City</th>
                                    <th>Pet Name</th>
                                    <th>Date Adopted</th>
                                    <th>Monitoring Date</th>
                                    <th>Monitoring Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result1 as $data1) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data1['adopter_fname'] . ' ' . $data1['adopter_lname']; ?></td>
                                        <td><?= $data1['city_name']; ?></td>
                                        <td><?= $data1['pet_name']; ?></td>
                                        <td><?= $data1['date_adopted']; ?></td>
                                        <td><?= $data1['monitoring_date']; ?></td>
                                        <td><?= $data1['monitoring_status']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['start_date'], $_SESSION['end_date']);
            } else if (isset($_SESSION['monitor_start_date'], $_SESSION['monitor_end_date'])) {
                $monitor_start_date = $_SESSION['monitor_start_date'];
                $monitor_end_date = $_SESSION['monitor_end_date'];

                $i = 1;
                $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id, city_tbl.city_name FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE (adopted_tbl.monitoring_date BETWEEN '$monitor_start_date' and '$monitor_end_date')";
                $result2 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result2) > 0) {
                    $total = mysqli_num_rows($result2);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Adopter Name</th>
                                    <th>City</th>
                                    <th>Pet Name</th>
                                    <th>Date Adopted</th>
                                    <th>Monitoring Date</th>
                                    <th>Monitoring Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result2 as $data2) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data2['adopter_fname'] . ' ' . $data2['adopter_lname']; ?></td>
                                        <td><?= $data2['city_name']; ?></td>
                                        <td><?= $data2['pet_name']; ?></td>
                                        <td><?= $data2['date_adopted']; ?></td>
                                        <td><?= $data2['monitoring_date']; ?></td>
                                        <td><?= $data2['monitoring_status']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['monitor_start_date'], $_SESSION['monitor_end_date']);
            } else if (isset($_SESSION['monitor_status'])) {
                $monitor_status = $_SESSION['monitor_status'];
                $i = 1;
                $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id, city_tbl.city_name FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adopted_tbl.monitoring_status = '$monitor_status'";
                $result3 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result3) > 0) {
                    $total = mysqli_num_rows($result3);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Adopter Name</th>
                                    <th>City</th>
                                    <th>Pet Name</th>
                                    <th>Date Adopted</th>
                                    <th>Monitoring Date</th>
                                    <th>Monitoring Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result3 as $data3) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data3['adopter_fname'] . ' ' . $data3['adopter_lname']; ?></td>
                                        <td><?= $data3['city_name']; ?></td>
                                        <td><?= $data3['pet_name']; ?></td>
                                        <td><?= $data3['date_adopted']; ?></td>
                                        <td><?= $data3['monitoring_date']; ?></td>
                                        <td><?= $data3['monitoring_status']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['monitor_status']);
            } else if (isset($_SESSION['city'])) {
                $city_id = $_SESSION['city'];
                $i = 1;
                $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id, city_tbl.city_name FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$city_id'";
                $result4 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result4) > 0) {
                    $total = mysqli_num_rows($result4);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Adopter Name</th>
                                    <th>City</th>
                                    <th>Pet Name</th>
                                    <th>Date Adopted</th>
                                    <th>Monitoring Date</th>
                                    <th>Monitoring Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($result4 as $data4) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data4['adopter_fname'] . ' ' . $data4['adopter_lname']; ?></td>
                                        <td><?= $data4['city_name']; ?></td>
                                        <td><?= $data4['pet_name']; ?></td>
                                        <td><?= $data4['date_adopted']; ?></td>
                                        <td><?= $data4['monitoring_date']; ?></td>
                                        <td><?= $data4['monitoring_status']; ?></td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['city']);
            } else {
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>City</th>
                            <th>Pet Name</th>
                            <th>Date Adopted</th>
                            <th>Monitoring Date</th>
                            <th>Monitoring Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT adopter_tbl.adopter_id, adopter_tbl.adopter_fname, adopter_tbl.adopter_lname, adoptee_tbl.pet_img1, adoptee_tbl.pet_img2, adoptee_tbl.pet_name, adopted_tbl.date_adopted, adopted_tbl.monitoring_date, adopted_tbl.monitoring_status, adopted_tbl.adopted_id, city_tbl.city_name FROM adopted_tbl INNER JOIN applicationform1 ON adopted_tbl.application_id = applicationform1.application_id INNER JOIN adopter_tbl ON applicationform1.adopter_id = adopter_tbl.adopter_id INNER JOIN adoptee_tbl ON applicationform1.pet_id = adoptee_tbl.pet_id INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                            $total = mysqli_num_rows($result);
                            foreach ($result as $data) {
                        ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $data['adopter_fname'] . ' ' . $data['adopter_lname']; ?></td>
                                    <td><?= $data['city_name']; ?></td>
                                    <td><?= $data['pet_name']; ?></td>
                                    <td><?= $data['date_adopted']; ?></td>
                                    <td><?= $data['monitoring_date']; ?></td>
                                    <td><?= $data['monitoring_status']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "No Record Found";
                        }
                        ?>
                        <br>
                        <?php echo "Total number of rows:" . "$total"; ?>
                    </tbody>
                </table>
            <?php
            }
            ?>
            <br>
        </div>
    </main>
</body>

</html>