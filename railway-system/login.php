<?php
session_start();

/* DB CONNECTION */
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

/* LOGIN LOGIC */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        /* VERIFY PASSWORD */
        if (password_verify($password, $user['password'])) {

            $_SESSION['username'] = $user['username'];

            /* REDIRECT (IMPORTANT - removes resubmission issue) */
            header("Location: home.php");
            exit();

        } else {
            $error = "Wrong Password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - PrimeRail</title>

    <style>
        body {
            margin:0;
            font-family:sans-serif;
            background:#0f172a;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box {
            background:white;
            padding:30px;
            width:320px;
            border-radius:10px;
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
            text-align:center;
        }

        h2 {
            margin-bottom:20px;
        }

        input {
            width:100%;
            padding:10px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:5px;
        }

        button {
            width:100%;
            padding:10px;
            background:#f97316;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover {
            background:#ea580c;
        }

        .error {
            color:red;
            font-size:14px;
        }

        .link {
            margin-top:10px;
        }

        .link a {
            text-decoration:none;
            color:#2563eb;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Login</h2>

    <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <div class="link">
        <a href="register.php">Create Account</a>
    </div>

</div>

</body>
</html>