<?php
session_start();

/* DB CONNECTION */
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

/* CHECK FORM SUBMIT */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    /* CHECK USER */
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        /* VERIFY PASSWORD */
        if (password_verify($password, $user['password'])) {

            /* LOGIN SUCCESS */
            $_SESSION['username'] = $user['username'];

            /* REDIRECT TO HOME PAGE */
            header("Location: home.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password'); window.location='login.php';</script>";
        }

    } else {
        echo "<script>alert('User not found'); window.location='login.php';</script>";
    }
}

$conn->close();
?>