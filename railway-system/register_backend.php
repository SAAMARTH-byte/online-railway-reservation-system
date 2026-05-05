<?php
session_start();

/* DB CONNECTION */
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

/* GET DATA */
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$captcha = $_POST['captcha'];

/* CAPTCHA CHECK */
if ($captcha != $_SESSION['captcha']) {
    die("Invalid Captcha");
}

/* PASSWORD CHECK */
if ($password != $confirm_password) {
    die("Passwords do not match");
}

/* HASH PASSWORD */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

/* CHECK DUPLICATE USER */
$check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    die("Username or Email already exists");
}

/* INSERT USER */
$sql = "INSERT INTO users (email, mobile, username, password)
VALUES ('$email', '$mobile', '$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {

    /* AUTO LOGIN */
    $_SESSION['username'] = $username;

    /* REDIRECT TO HOME/DASHBOARD */
    header("Location:home.php");
    exit();

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>