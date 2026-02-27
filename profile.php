<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_query = mysqli_query($conn, "SELECT fullname, email FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f2f2f2;
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
    background:#f2f2f2;
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

/* OVERLAY */
.overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    opacity:0;
    visibility:hidden;
    transition:0.3s;
    z-index:1500;
}

.overlay.active{
    opacity:1;
    visibility:visible;
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

.profile-content a{
    text-decoration:none;
    color:white;
}

.profile-content a:visited{
    color:white;
}

.profile-pic{
    width:110px;
    height:110px;
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

/* MAIN PROFILE SECTION */
.container{
    margin-top:120px;
    padding:20px;
    text-align:center;
}

.main-pic{
    width:120px;
    height:120px;
    border-radius:50%;
    background:#ccc;
    margin:15px auto;
}

.user-name{
    font-weight:bold;
    color:#0b3d70;
    margin-bottom:5px;
    font-size:25px;
}

.user-email{
    font-size:13px;
    margin-bottom:13px;
}

.stats{
    margin-bottom:20px;
    font-size:14px;
}

/* BUTTONS */
.button-row{
    display:flex;
    justify-content:center;
    gap:10px;
    margin-bottom:25px;
}

.button-row a{
    padding:10px 15px;
    border-radius:5px;
    text-decoration:none;
    font-weight:bold;
    font-size:13px;
}

.primary-btn{
    background:#0b3d70;
    color:white;
}

.gray-btn{
    background:#777;
    color:white;
}

/* CARDS */
.card{
    background:white;
    border:2px solid #0b3d70;
    border-radius:15px;
    padding:15px;
    margin-bottom:20px;
    text-align:left;
}

.card p{
    margin-bottom:5px;
    font-size:14px;
}

.card-buttons{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.card-buttons a{
    flex:1;
    padding:8px;
    text-align:center;
    border-radius:5px;
    font-size:12px;
    text-decoration:none;
    color:white;
}

.view-btn{
    background:#2e59c5;
}

.reopen-btn{
    background:#5a9c44;
}

h1{
    text-align:center;
    color:#0b3d70;
    margin-bottom:15px;
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

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<div class="sidebar" id="sidebar">
    <div class="profile-header">
        <div class="profile-content">
            <a href="menu.php">
                <img src="image/user.png" class="profile-pic">
                <div class="profile-name"><?php echo $user['fullname']; ?></div>
                <div class="profile-email"><?php echo $user['email']; ?></div>
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
        <h1>Profile</h1>

<img src="image/user.png" class="profile-pic">

<div class="user-name"><?php echo $user['fullname']; ?></div>
<div class="user-email"><?php echo $user['email']; ?></div>

<div class="stats">
Active Listings: <?php echo $activeListings; ?> |
Pending Claims: <?php echo $pendingClaims; ?>
</div>


<div class="button-row">
    <a href="profile.php" class="primary-btn">My Listed Items</a>
    <a href="viewclaims.php" class="gray-btn">View Claims</a>
    <a href="myclaims.php" class="gray-btn">My Claims</a>
</div>

<h3>Manage your found items and review claims.</h3>

<div class="card">
    <p><strong>ID:</strong> 01C</p>
    <p><strong>Item Name:</strong> Pink Wallet</p>
    <p><strong>Status:</strong> Pending</p>
    <p><strong>Claims:</strong> 3</p>

    <div class="card-buttons">
        <a href="viewclaims.php" class="view-btn">View Claims</a>
        <a href="reopenitem.php" class="reopen-btn">Reopen Item</a>
    </div>
</div>

<div class="card">
    <p><strong>ID:</strong> 01A</p>
    <p><strong>Item Name:</strong> Pink Aquaflask Water Bottle</p>
    <p><strong>Status:</strong> Available</p>
    <p><strong>Claims:</strong> 0</p>

    <div class="card-buttons">
        <a href="viewclaims.php" class="view-btn">View Claims</a>
    </div>
</div>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
</script>

</body>
</html>
