<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    elseif (!str_contains($email, "@hau.edu.ph")) {
        $error = "Please use your HAU email.";
    } 
    else {
        $success = "Message sent successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:white;
    margin:0;
}

/* HEADER */
header{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:white;
    z-index:1000;
}

.logo{
    width:150px;
}

/* HAMBURGER */
.hamburger{
    width:28px;
    cursor:pointer;
}

.hamburger div{
    height:4px;
    background:#0b3d70;
    margin:5px 0;
    border-radius:2px;
}

/* OVERLAY */
.menu-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    opacity:0;
    visibility:hidden;
    transition:0.3s;
    z-index:1500;
}

.menu-overlay.active{
    opacity:1;
    visibility:visible;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    right:-100%;
    top:0;
    width:85%;
    height:100%;
    background:#f2f2f2;
    transition:0.3s ease;
    z-index:2000;
    overflow-y:auto;
}

.sidebar.active{
    right:0;
}

/* PROFILE HEADER */
.profile-header{
    background:url("image/menubg.png") no-repeat center center;
    background-size:cover;
    padding:25px 20px;
    color:white;
    position:relative;
}

.profile-header::after{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.5);
}

.profile-content{
    position:relative;
    z-index:2;
}

/* REMOVE PURPLE LINK */
.profile-content a{
    text-decoration:none;
    color:white;
}

.profile-content a:visited,
.profile-content a:hover,
.profile-content a:active{
    color:white;
}

.profile-pic{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:10px;
}

.profile-name{
    font-weight:bold;
    font-size:16px;
}

.profile-email{
    font-size:13px;
}

.bell{
    position:absolute;
    right:20px;
    top:20px;
    font-size:22px;
    z-index:2;
}

/* MENU ITEMS */
.menu-item{
    display:flex;
    align-items:center;
    padding:18px 20px;
    font-size:16px;
    color:#555;
    text-decoration:none;
    border-bottom:1px solid #ddd;
}

.menu-item img{
    width:25px;
    margin-right:15px;
}

.menu-item:hover{
    background:#e6e6e6;
}

/* CONTENT */
.container{
    background:white;
    color:#333;
    padding:25px;
    margin:120px auto 40px;
    max-width:500px;
    width:90%;
    border-top-left-radius:30px;
    border-top-right-radius:30px;
}

h1{
    text-align:center;
    color:#0b3d70;
    margin-bottom:15px;
}

.description{
    text-align:center;
    font-size:14px;
    line-height:1.6;
    margin-bottom:25px;
}

.info-box{
    border:2px solid #2f6f8f;
    border-radius:15px;
    padding:12px;
    margin-bottom:15px;
    color:#0b3d70;
    text-align:center;
    font-weight:500;
}

h2{
    text-align:center;
    margin:25px 0 15px;
    color:#0b3d70;
}

input, textarea{
    width:100%;
    padding:12px;
    border-radius:6px;
    border:1px solid #ccc;
    margin-bottom:15px;
    font-size:14px;
}

textarea{
    resize:none;
}

button{
    background:#0b3d70;
    color:white;
    padding:10px 20px;
    border:none;
    border-radius:4px;
    float:right;
    cursor:pointer;
}

.success{
    color:green;
    text-align:center;
    margin-bottom:10px;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
}
</style>
</head>

<body>

<header>
    <img src="image/logo.png" class="logo">
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>

<div class="menu-overlay" id="menuOverlay" onclick="toggleMenu()"></div>

<div class="sidebar" id="sidebar">

    <div class="profile-header">
        <div class="bell">🔔</div>
        <div class="profile-content">
            <a href="menu.php">
                <img src="image/user.png" class="profile-pic" alt="Profile">
                <div class="profile-name"><?php echo $_SESSION['fullname']; ?></div>
                <div class="profile-email"><?php echo $_SESSION['email']; ?></div>
            </a>
        </div>
    </div>

    <a href="home.php" class="menu-item">
        <img src="image/home.png"> Home
    </a>

    <a href="browse.php" class="menu-item">
        <img src="image/lost.png"> Browse
    </a>

    <a href="list.php" class="menu-item">
        <img src="image/list.png"> List
    </a>

    <a href="claim.php" class="menu-item">
        <img src="image/found.png"> Claim
    </a>

    <a href="profile.php" class="menu-item">
        <img src="image/profile.png"> Profile
    </a>

    <a href="contactus.php" class="menu-item">
        <img src="image/contact.png"> Contact Us
    </a>

    <a href="logout.php" class="menu-item">
        <img src="image/out.png"> Log Out
    </a>

</div>

<div class="container">

<h1>Contact Us</h1>

<p class="description">
FoundIt is a web-based system developed by BSIT students of Holy Angel University as part of an academic project.
</p>

<div class="info-box">foundit@hau.edu.ph</div>
<div class="info-box">Holy Angel University, Angeles City</div>

<h2>Contact Form</h2>

<?php if($success): ?>
<div class="success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if($error): ?>
<div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="HAU Email *" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" rows="5" placeholder="Message" required></textarea>
    <button type="submit">Send</button>
</form>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("menuOverlay").classList.toggle("active");
}
</script>

</body>
</html>
