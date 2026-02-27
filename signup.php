<?php
session_start();
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Get form values safely
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Combine first and last name
    $fullname = $fname . " " . $lname;

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already registered!');</script>";
    } else {

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $query = "INSERT INTO users (fullname, email, password)
                  VALUES ('$fullname', '$email', '$hashed_password')";

        if(mysqli_query($conn, $query)){

            // Auto login after signup
            $_SESSION['user_id'] = mysqli_insert_id($conn);

            header("Location: home.php");
            exit();

        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Foundit</title>

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
    align-items: center; /* vertical center */
    padding: 20px;
}

/* Main Wrapper */
.wrapper {
    width: 100%;
    max-width: 430px;
}

/* Logo */
.logo {
    width: 300px;
    display: block;
    margin: 0 auto 25px;
}

/* Card */
.card {
    background: linear-gradient(to bottom right, rgba(30,87,153,0.9), rgba(58,123,213,0.9));
    padding: 25px;
    border-radius: 25px;
    color: white;
}

/* Headings */
.card h1 {
    font-size: 28px;
    margin-bottom: 5px;
}

.card p {
    margin-bottom: 20px;
    font-size: 14px;
}

.card p a {
    color: #dbe9ff;
    text-decoration: underline;
}

/* Inputs */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: none;
    margin-bottom: 15px;
    font-size: 14px;
}

/* Name row */
.name-row {
    display: flex;
    gap: 10px;
}

.name-row input {
    flex: 1;
}

/* Password */
.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 12px;
    cursor: pointer;
}

/* Terms */
.terms {
    display: flex;
    align-items: center;
    font-size: 13px;
    margin-bottom: 20px;
}

.terms input {
    margin-right: 8px;
}

.terms a {
    color: #dbe9ff;
    text-decoration: underline;
}

/* Button */
.signup-btn {
    width: 100%;
    padding: 13px;
    background-color: #244f82;
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

/* Divider */
.divider {
    display: flex;
    align-items: center;
    margin: 25px 0 15px;
    font-size: 12px;
}

.divider::before,
.divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: white;
}

.divider span {
    margin: 0 10px;
}

/* Social */
.social {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.social-btn {
    flex: 1;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    background: white;
    color: black;
}
</style>

</head>
<body>

<div class="wrapper">   

    <img src="image/logo.png" class="logo" alt="Foundit Logo">

    <div class="card">

        <h1>Create an Account</h1>
        <p>Already have an account? <a href="index.php">Log in</a></p>

        <form method="POST">

            <div class="name-row">
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
            </div>

            <input type="email" name="email" placeholder="HAU Email" required>

            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <span class="toggle-password" onclick="togglePassword()"></span>
            </div>

            <div class="terms">
                <input type="checkbox" name="terms" required>
                <label>I agree to the <a href="https://www.hau.edu.ph/services/newstudent-guide">Terms & Conditions</a></label>
            </div>

            <button type="submit" class="signup-btn">SIGN UP</button>

        </form>

        <div class="divider">
            <span>or register with</span>
        </div>

        <div class="social">
            <a href="https://myaccount.google.com" target="_blank" class="social-btn">Google</a>
            <a href="https://account.apple.com/" target="_blank" class="social-btn">Apple</a>
        </div>

    </div>

</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    password.type = password.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
