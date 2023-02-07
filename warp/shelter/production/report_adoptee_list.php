<?php
session_start();
include 'config.php';
include('export.php');



if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
    header('Location:/login.php');
} else {
    $role_id = $_SESSION['user-role-id'];
    if ($role_id == 2) {
        htmlspecialchars($_SERVER['PHP_SELF']);
    } else {
        header('Location:/home.php');
    }
}
?>

<?php
// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];
// Query to check if user_id from the login shesh = shelteruser_id to get the city 
$sql = "SELECT * FROM shelteruser_tbl WHERE user_id ='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $city_id = $row['city_id'];
    $sql = "SELECT * FROM city_tbl INNER JOIN shelteruser_tbl ON city_tbl.city_id = shelteruser_tbl.city_id WHERE city_tbl.city_id AND shelteruser_tbl.city_id ='$city_id'";
    $result2 = mysqli_query($conn, $sql);
    if ($result2 == TRUE) {
        $row2 = mysqli_fetch_assoc($result2);
    }
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
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
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
            left: 100px;
        }

        header .report_filter {
            display: inline-block;
            position: absolute;
            top: 32px;
            left: 100px;
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
            <img src="images/logo/<?= $row2['city_img']; ?>" alt="" width="80" height="80">
        </div>
        <div class="report_title">
            <h3><?= $row2['city_name'] . " " . "Animal Shelter"; ?></h3>
        </div>
        <div class="report_filter">
            <p>Adoptee List:
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
                $sql = "SELECT * FROM adoptee_tbl WHERE (created_at BETWEEN '$start_date' and '$end_date') AND adoptee_tbl.city_id = '$city_id'";
                $result1 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result1) > 0) {
                    $total = mysqli_num_rows($result1);
            ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neutered/Spayed</th>
                                    <th>Weight</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result1 as $data1) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data1['pet_name']; ?></td>
                                        <td><?= $data1['pet_age']; ?></td>
                                        <td><?= $data1['pet_color']; ?></td>
                                        <td><?= $data1['pet_breed']; ?></td>
                                        <td><?= $data1['pet_specie']; ?></td>
                                        <td><?= $data1['pet_gender']; ?></td>
                                        <td><?= $data1['pet_neuter']; ?></td>
                                        <td><?= $data1['pet_weight']; ?>kg</td>
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
                $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_specie = '$specie' AND adoptee_tbl.city_id = '$city_id'";
                $result2 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result2) > 0) {
                    $total = mysqli_num_rows($result2);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neutered/Spayed</th>
                                    <th>Weight</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result2 as $data2) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data2['pet_name']; ?></td>
                                        <td><?= $data2['pet_age']; ?></td>
                                        <td><?= $data2['pet_color']; ?></td>
                                        <td><?= $data2['pet_breed']; ?></td>
                                        <td><?= $data2['pet_specie']; ?></td>
                                        <td><?= $data2['pet_gender']; ?></td>
                                        <td><?= $data2['pet_neuter']; ?></td>
                                        <td><?= $data2['pet_weight']; ?>kg</td>
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
                $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_gender = '$gender' AND adoptee_tbl.city_id = '$city_id'";
                $result3 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result3) > 0) {
                    $total = mysqli_num_rows($result3);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neutered/Spayed</th>
                                    <th>Weight</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result3 as $data3) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data3['pet_name']; ?></td>
                                        <td><?= $data3['pet_age']; ?></td>
                                        <td><?= $data3['pet_color']; ?></td>
                                        <td><?= $data3['pet_breed']; ?></td>
                                        <td><?= $data3['pet_specie']; ?></td>
                                        <td><?= $data3['pet_gender']; ?></td>
                                        <td><?= $data3['pet_neuter']; ?></td>
                                        <td><?= $data3['pet_weight']; ?>kg</td>
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
                $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_size = '$size' AND adoptee_tbl.city_id = '$city_id'";
                $result4 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result4) > 0) {
                    $total = mysqli_num_rows($result4);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neutered/Spayed</th>
                                    <th>Weight</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result4 as $data4) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data4['pet_name']; ?></td>
                                        <td><?= $data4['pet_age']; ?></td>
                                        <td><?= $data4['pet_color']; ?></td>
                                        <td><?= $data4['pet_breed']; ?></td>
                                        <td><?= $data4['pet_specie']; ?></td>
                                        <td><?= $data4['pet_gender']; ?></td>
                                        <td><?= $data4['pet_neuter']; ?></td>
                                        <td><?= $data4['pet_weight']; ?>kg</td>
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
                $sql = "SELECT * FROM adoptee_tbl WHERE adoptee_tbl.pet_neuter = '$neuter' AND adoptee_tbl.city_id = '$city_id'";
                $result5 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result5) > 0) {
                    $total = mysqli_num_rows($result5);
                ?>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Color</th>
                                    <th>Breed</th>
                                    <th>Specie</th>
                                    <th>Sex</th>
                                    <th>Neutered/Spayed</th>
                                    <th>Weight</th>
                                    <th>Size</th>
                                    <th>Date&nbsp;Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result5 as $data5) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $data5['pet_name']; ?></td>
                                        <td><?= $data5['pet_age']; ?></td>
                                        <td><?= $data5['pet_color']; ?></td>
                                        <td><?= $data5['pet_breed']; ?></td>
                                        <td><?= $data5['pet_specie']; ?></td>
                                        <td><?= $data5['pet_gender']; ?></td>
                                        <td><?= $data5['pet_neuter']; ?></td>
                                        <td><?= $data5['pet_weight']; ?>kg</td>
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
            } else {
                $i = 1;
                $sql = "SELECT * FROM adoptee_tbl WHERE city_id='$city_id'";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total = mysqli_num_rows($result);
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Color</th>
                                <th>Breed</th>
                                <th>Specie</th>
                                <th>Sex</th>
                                <th>Neutered/Spayed</th>
                                <th>Weight</th>
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
                                    <td><?= $data['pet_name']; ?></td>
                                    <td><?= $data['pet_age']; ?></td>
                                    <td><?= $data['pet_color']; ?></td>
                                    <td><?= $data['pet_breed']; ?></td>
                                    <td><?= $data['pet_specie']; ?></td>
                                    <td><?= $data['pet_gender']; ?></td>
                                    <td><?= $data['pet_neuter']; ?></td>
                                    <td><?= $data['pet_weight']; ?>kg</td>
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
        </div>
    </main>
</body>

</html>