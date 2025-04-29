<?php
session_start();
include 'db.php';

// submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = mysqli_real_escape_string($conn, $_POST['password']);

    $found = false;

    // Individuals 
    $sql_individual = "SELECT * FROM individuals WHERE email='$email'";
    $result_individual = mysqli_query($conn, $sql_individual);
    if (mysqli_num_rows($result_individual) == 1) {
        $user = mysqli_fetch_assoc($result_individual);
        if (password_verify($password_input, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'individual';
            $_SESSION['email'] = $user['email'];
            $found = true;
        }
    }

    // Hospitals 
    if (!$found) {
        $sql_hospital = "SELECT * FROM hospitals WHERE email='$email'";
        $result_hospital = mysqli_query($conn, $sql_hospital);
        if (mysqli_num_rows($result_hospital) == 1) {
            $user = mysqli_fetch_assoc($result_hospital);
            if (password_verify($password_input, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = 'hospital';
                $_SESSION['email'] = $user['email'];
                $found = true;
            }
        }
    }

    // Bloodbanks 
    if (!$found) {
        $sql_bloodbank = "SELECT * FROM bloodbanks WHERE email='$email'";
        $result_bloodbank = mysqli_query($conn, $sql_bloodbank);
        if (mysqli_num_rows($result_bloodbank) == 1) {
            $user = mysqli_fetch_assoc($result_bloodbank);
            if (password_verify($password_input, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = 'bloodbank';
                $_SESSION['email'] = $user['email'];
                $found = true;
            }
        }
    }

    if ($found) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Login failed. Please check your credentials.";
    }
}
?>
