<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user-email'], $_SESSION['user-role-id'])) {
    header('Location:/Capstone/warp/login.php');
} else {
    $role_id = $_SESSION['user-role-id'];
    if ($role_id == 2) {
        htmlspecialchars($_SERVER['PHP_SELF']);
    } else {
        header('Location:/Capstone/warp/home.php');
    }
}
// Get the user ID from the login sesh
$user_id = $_SESSION['user_id'];

// Get user-email for change pass
$user_email = $_SESSION['user-email'];

?>

<?php
if (isset($_POST['submit-pass'])) {

    // Validate current password
    if (empty($_POST['curpassword'])) {
        $curpassErr = 'Current Password is required';
    } else {
        $curpass = filter_input(
            INPUT_POST,
            'curpassword',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    // Validate new password
    if (empty($_POST['newpassword'])) {
        $newpassErr = 'New Password is required';
    } else {
        $newpass = filter_input(
            INPUT_POST,
            'newpassword',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    // Validate confirm new password
    if (empty($_POST['conpassword'])) {
        $conpassErr = 'Confirm Password is required';
    } else {
        $conpass = filter_input(
            INPUT_POST,
            'conpassword',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    if (empty($curpassErr) && empty($newpassErr) && empty($conpassErr)) {

        //Get muna ung hashedpass sa user_tbl then validate kung same sa curpassword
        $sql = "SELECT user_password FROM user_tbl WHERE user_id = ? AND user_email = ? AND role_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL Prepared Statement Failed";
        } else {
            mysqli_stmt_bind_param($stmt, "isi", $user_id, $user_email, $role_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $curhashpass = $row['user_password'];
                if (password_verify($curpass, $curhashpass)) {
                    // If the curpass == curhashpass validate new pass with confirm pass
                    if ($newpass == $conpass) {
                        $pass = password_hash($newpass, PASSWORD_DEFAULT);
                        $sql2 = "UPDATE user_tbl SET user_password = ? WHERE user_id = ? AND user_email = ? and role_id = ?";
                        $stmt2 = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                            echo "SQL Prepared Statement Failed";
                        } else {
                            mysqli_stmt_bind_param($stmt2, "sisi", $pass, $user_id, $user_email, $role_id);
                            
                            mysqli_stmt_execute($stmt2);
                            echo "<script>alert('Password Changed Successfully!')</script>";
                            echo "<script>window.location.href='shelter_account.php';</script>";
                           
                        }
                    } else {
                        echo "<script>alert('Your new password doesnt match with the confirm password!')</script>";
                        echo "<script>window.location.href='changepass.php';</script>";
                    }
                } else {
                    echo "<script>alert('Your new password doesnt match with the current password!')</script>";
                    echo "<script>window.location.href='changepass.php';</script>";
                }
            } else {
                echo "<script>alert('The account doesn't exist!')</script>";
                echo "<script>window.location.href='changepass.php';</script>";
            }
        }
    }
}
?>