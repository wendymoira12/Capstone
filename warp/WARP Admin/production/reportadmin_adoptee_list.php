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
            <h3>Pet Adoptee List</h3>
        </div>
        <div class="report_filter">
            <p>
                <?php
                if (isset($_SESSION['start_date'], $_SESSION['end_date'])) {
                    $start_date = $_SESSION['start_date'];
                    $end_date = $_SESSION['end_date'];
                    echo "Filtered by date from" . " $start_date " . " to " . " $end_date ";
                } else if (isset($_SESSION['specie'])) {
                    echo "Specie";
                } else if (isset($_SESSION['gender'])) {
                    echo "Gender";
                } else if (isset($_SESSION['size'])) {
                    echo "Size";
                } else if (isset($_SESSION['neuter'])) {
                    echo "Neuter";
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
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE (created_at BETWEEN '$start_date' and '$end_date')";
                $result1 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result1) > 0) {
                    $total = mysqli_num_rows($result1);
            ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result1 as $data1) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data1['city_name']; ?></td>
                                        <td><?= $data1['pet_name']; ?></td>
                                        <td><?= $data1['pet_age']; ?></td>
                                        <td><?= $data1['pet_color']; ?></td>
                                        <td><?= $data1['pet_breed']; ?></td>
                                        <td><?= $data1['pet_specie']; ?></td>
                                        <td><?= $data1['pet_gender']; ?></td>
                                        <td><?= $data1['pet_neuter']; ?></td>
                                        <td><?= $data1['pet_size']; ?></td>
                                        <td><?= $data1['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['start_date'], $_SESSION['end_date']);
            } else if (isset($_SESSION['specie'])) {
                $i = 1;
                $specie = $_SESSION['specie'];
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.pet_specie = '$specie'";
                $result2 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result2) > 0) {
                    $total = mysqli_num_rows($result2);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result2 as $data2) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data2['city_name']; ?></td>
                                        <td><?= $data2['pet_name']; ?></td>
                                        <td><?= $data2['pet_age']; ?></td>
                                        <td><?= $data2['pet_color']; ?></td>
                                        <td><?= $data2['pet_breed']; ?></td>
                                        <td><?= $data2['pet_specie']; ?></td>
                                        <td><?= $data2['pet_gender']; ?></td>
                                        <td><?= $data2['pet_neuter']; ?></td>
                                        <td><?= $data2['pet_size']; ?></td>
                                        <td><?= $data2['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['specie']);
            } else if (isset($_SESSION['gender'])) {
                $i = 1;
                $gender = $_SESSION['gender'];
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.pet_gender = '$gender'";
                $result3 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result3) > 0) {
                    $total = mysqli_num_rows($result3);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result3 as $data3) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data3['city_name']; ?></td>
                                        <td><?= $data3['pet_name']; ?></td>
                                        <td><?= $data3['pet_age']; ?></td>
                                        <td><?= $data3['pet_color']; ?></td>
                                        <td><?= $data3['pet_breed']; ?></td>
                                        <td><?= $data3['pet_specie']; ?></td>
                                        <td><?= $data3['pet_gender']; ?></td>
                                        <td><?= $data3['pet_neuter']; ?></td>
                                        <td><?= $data3['pet_size']; ?></td>
                                        <td><?= $data3['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['gender']);
            } else if (isset($_SESSION['size'])) {
                $i = 1;
                $size = $_SESSION['size'];
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.pet_size = '$size'";
                $result4 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result4) > 0) {
                    $total = mysqli_num_rows($result4);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result4 as $data4) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data4['city_name']; ?></td>
                                        <td><?= $data4['pet_name']; ?></td>
                                        <td><?= $data4['pet_age']; ?></td>
                                        <td><?= $data4['pet_color']; ?></td>
                                        <td><?= $data4['pet_breed']; ?></td>
                                        <td><?= $data4['pet_specie']; ?></td>
                                        <td><?= $data4['pet_gender']; ?></td>
                                        <td><?= $data4['pet_neuter']; ?></td>
                                        <td><?= $data4['pet_size']; ?></td>
                                        <td><?= $data4['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['size']);
            } else if (isset($_SESSION['neuter'])) {
                $i = 1;
                $neuter = $_SESSION['neuter'];
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.pet_neuter = '$neuter'";
                $result5 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result5) > 0) {
                    $total = mysqli_num_rows($result5);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result5 as $data5) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data5['city_name']; ?></td>
                                        <td><?= $data5['pet_name']; ?></td>
                                        <td><?= $data5['pet_age']; ?></td>
                                        <td><?= $data5['pet_color']; ?></td>
                                        <td><?= $data5['pet_breed']; ?></td>
                                        <td><?= $data5['pet_specie']; ?></td>
                                        <td><?= $data5['pet_gender']; ?></td>
                                        <td><?= $data5['pet_neuter']; ?></td>
                                        <td><?= $data5['pet_size']; ?></td>
                                        <td><?= $data5['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['neuter']);
            } else if (isset($_SESSION['city'])) {
                $i = 1;
                $city_id = $_SESSION['city'];
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id WHERE adoptee_tbl.city_id = '$city_id'";
                $result6 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result6) > 0) {
                    $total = mysqli_num_rows($result6);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neuter/Spayed</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result6 as $data6) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data6['city_name']; ?></td>
                                        <td><?= $data6['pet_name']; ?></td>
                                        <td><?= $data6['pet_age']; ?></td>
                                        <td><?= $data6['pet_color']; ?></td>
                                        <td><?= $data6['pet_breed']; ?></td>
                                        <td><?= $data6['pet_specie']; ?></td>
                                        <td><?= $data6['pet_gender']; ?></td>
                                        <td><?= $data6['pet_neuter']; ?></td>
                                        <td><?= $data6['pet_size']; ?></td>
                                        <td><?= $data6['created_at']; ?></td>
                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php echo "Total number of rows:" . " " . "$total"; ?>
                    </div>
                <?php
                } else {
                    echo "No Record Found";
                }
                unset($_SESSION['city']);
            } else {
                $i = 1;
                $sql = "SELECT *, city_tbl.city_name FROM adoptee_tbl INNER JOIN city_tbl ON adoptee_tbl.city_id = city_tbl.city_id";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total = mysqli_num_rows($result);
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>City</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Color</th>
                                <th>Breed</th>
                                <th>Specie</th>
                                <th>Sex</th>
                                <th>Neuter/Spayed</th>
                                <th>Size</th>
                                <th>Date&nbsp;Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($result as $data) {

                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $data['city_name']; ?></td>
                                    <td><?= $data['pet_name']; ?></td>
                                    <td><?= $data['pet_age']; ?></td>
                                    <td><?= $data['pet_color']; ?></td>
                                    <td><?= $data['pet_breed']; ?></td>
                                    <td><?= $data['pet_specie']; ?></td>
                                    <td><?= $data['pet_gender']; ?></td>
                                    <td><?= $data['pet_neuter']; ?></td>
                                    <td><?= $data['pet_size']; ?></td>
                                    <td><?= $data['created_at']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "No Record Found";
                        }
                        ?>

                        </tbody>
                    </table>
                    <br>
                    <?php
                    if (!empty($total)) {
                        echo "Total number of rows:" . " " . "$total";
                    }
                    ?>
                <?php
            }
                ?>
                <br>
        </div>
    </main>
</body>

</html>