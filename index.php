<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            header("Location: home.php");
            exit();

        } else {
            echo "<script>alert('Invalid Email or Password');</script>";
        }

    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Foundit - Login</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: url("image/bg.png") no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    display: flex;
    justify-content: center;
}

/* Main container */
.container {
    width: 100%;
    max-width: 430px;
    padding: 40px 25px;
    text-align: center;
}

/* Logo */
.logo {
    width: 300px;
    margin: 80px auto 40px;
}

/* Inputs */
.login-form input {
    width: 100%;
    padding: 14px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: none;
    font-size: 15px;
}

/* Password */
.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 14px;
    cursor: pointer;
}

/* Forgot */
.forgot {
    display: block;
    font-size: 12px;
    text-align: right;
    margin-bottom: 20px;
    color: #1f4f82;
    text-decoration: none;
}

/* Login Button */
.login-btn {
    width: 100%;
    padding: 14px;
    background-color: #2d5f94;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
}

/* Social */
.social {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.social-btn {
    flex: 1;
    padding: 12px;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    background: white;
    color: black;
}

/* Divider */
.signup {
    display: flex;
    align-items: center;
    margin-top: 50px;
}

.line {
    flex: 1;
    height: 1px;
    background: #1f4f82;
}

.signup p {
    margin: 0 10px;
    font-size: 12px;
    color: #1f4f82;
}

/* Create */
.create {
    margin-top: 10px;
    font-size: 13px;
}

.create a {
    font-weight: bold;
    color: black;
    text-decoration: underline;
}
</style>

</head>
<body>

<div class="container">

    <img src="image/logo.png" alt="Foundit Logo" class="logo">

    <form method="POST" class="login-form">

        <input type="email" name="email" placeholder="HAU Email" required>

        <div class="password-wrapper">
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <span class="toggle-password" onclick="togglePassword()"></span>
        </div>

        <a href="https://support.google.com/mail/?hl=en#topic=7065107" target="_blank" class="forgot">
            FORGOT PASSWORD?
        </a>

        <button type="submit" class="login-btn">LOG IN</button>


    </form>

    <div class="social">
        <a href="https://myaccount.google.com/" target="_blank" class="social-btn">Google</a>
        <a href="https://account.apple.com/" target="_blank" class="social-btn">Apple</a>
    </div>

    <div class="signup">
        <div class="line"></div>
        <p>DON'T HAVE AN ACCOUNT?</p>
        <div class="line"></div>
    </div>

    <p class="create">
        CREATE ONE <a href="signup.php">HERE!</a>
    </p>

</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    password.type = password.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
