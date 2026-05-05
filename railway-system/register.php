<?php
session_start();

/* Simple captcha */
$captcha = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"),0,6);
$_SESSION['captcha'] = $captcha;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - PrimeRail</title>

    <style>
        * {
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body {
            background:#0f172a;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:flex-start;
            padding:40px 0;
        }

        .container {
            width:420px;
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
        }

        h2 {
            text-align:center;
            margin-bottom:20px;
            color:#1e293b;
        }

        .input-box {
            margin-bottom:15px;
        }

        label {
            font-size:13px;
            font-weight:600;
            color:#334155;
        }

        input {
            width:100%;
            padding:10px;
            margin-top:5px;
            border:1px solid #cbd5e1;
            border-radius:6px;
            outline:none;
        }

        input:focus {
            border-color:#f97316;
        }

        .captcha-box {
            display:flex;
            align-items:center;
            gap:10px;
            margin-top:5px;
        }

        .captcha {
            background:#1e293b;
            color:white;
            padding:10px 15px;
            border-radius:6px;
            font-weight:bold;
            letter-spacing:2px;
        }

        .btn {
            width:100%;
            padding:12px;
            margin-top:15px;
            background:linear-gradient(45deg,#f97316,#ea580c);
            color:white;
            border:none;
            border-radius:6px;
            font-size:15px;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover {
            transform:scale(1.03);
        }

        .login-link {
            text-align:center;
            margin-top:10px;
        }

        .login-link a {
            color:#2563eb;
            text-decoration:none;
            font-size:14px;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>Create Account</h2>

    <form action="register_backend.php" method="POST">

        <div class="input-box">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-box">
            <label>Full Name </label>
            <input type="text" name="name" required>
        </div>

        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-box">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </div>

        <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-box">
            <label>Mobile Number</label>
            <input type="text" name="mobile" placeholder="10 digit number" required>
        </div>


        <div class="input-box">
            <label>Enter Captcha</label>

            <div class="captcha-box">
                <div class="captcha"><?php echo $captcha; ?></div>
                <input type="text" name="captcha" required>
            </div>
        </div>

        <button class="btn">Register</button>

    </form>


</div>

</body>
</html>