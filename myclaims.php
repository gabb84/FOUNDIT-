<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

include("config.php");

$user_id = $_SESSION['user_id'];

$query = "
SELECT claims.*, items.item_name, items.id AS item_code
FROM claims
JOIN items ON claims.item_id = items.id
WHERE claims.user_id='$user_id'
ORDER BY claims.created_at DESC
";

$result = mysqli_query($conn,$query);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Claims</title>

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
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
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
    z-index:1000;
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
    z-index:900;
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
    width:70px;
    height:70px;
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

/* MAIN CONTAINER */
.container{
    padding:20px;
}

/* PAGE TITLE */
.page-title{
    text-align:center;
    font-size:28px;
    font-weight:bold;
    color:#0b3d70;
    margin-top:10px;
}

/* PROFILE TOP */
.profile-top{
    text-align:center;
    margin-top:20px;
    margin-bottom:15px;
}

.profile-main-pic{
    width:110px;
    height:110px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:10px;
}

.profile-top h2{
    color:#0b3d70;
    margin-bottom:5px;
}

.email{
    font-size:14px;
    color:#555;
}

.stats{
    margin-top:8px;
    color:#0b3d70;
    font-weight:500;
}

/* BUTTON ROW */
.button-row{
    display:flex;
    justify-content:center;
    gap:10px;
    margin:20px 0;
}

.button-row a{
    padding:10px 15px;
    border-radius:6px;
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

/* DESCRIPTION */
.subtitle{
    text-align:center;
    font-weight:bold;
    color:#0b3d70;
    margin-bottom:20px;
}

/* CLAIM CARD */
.claim-card{
    background:white;
    border:2px solid #0b3d70;
    border-radius:15px;
    padding:15px;
    margin-bottom:20px;
}

.claim-card p{
    margin-bottom:6px;
}

.highlight{
    color:#0b3d70;
    font-weight:bold;
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
            <div class="profile-name"><?php echo $_SESSION['fullname']; ?></div>
            <div class="profile-email"><?php echo $_SESSION['email']; ?></div>
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

<h1>My Claims</h1>

<div class="profile-top">
    <img src="image/user.png" class="profile-main-pic">

    <h2><?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>

    <p class="email"><?php echo htmlspecialchars($_SESSION['email']); ?></p>

    <p class="stats">My submitted claims will appear below.</p>
</div>

<div class="button-row">
    <a href="profile.php" class="gray-btn">My Listed Items</a>
    <a href="viewclaims.php" class="gray-btn">View Claims</a>
    <a href="myclaims.php" class="primary-btn">My Claims</a>
</div>

<p class="subtitle">Track the status of items you have attempted to claim.</p>
<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="claim-card">
            <p><strong>Item ID:</strong> FI-<?php echo htmlspecialchars($row['item_code']); ?></p>
            <p><strong>Item Name:</strong> <?php echo htmlspecialchars($row['item_name']); ?></p>
            <p><strong>Status:</strong> 
                <span class="highlight">
                    <?php echo ucfirst(htmlspecialchars($row['status'])); ?>
                </span>
            </p>
            <p><strong>Date Submitted:</strong> <?php echo date("F d, Y", strtotime($row['created_at'])); ?></p>
            
            <?php if($row['status'] == 'pending'): ?>
                <p>The finder is currently <span class="highlight">reviewing</span> your claim.</p>
            <?php elseif($row['status'] == 'approved'): ?>
                <p>The finder has <span style="color: green; font-weight: bold;">approved</span> your claim!</p>
                <p>You may now coordinate through HAU email.</p>
            <?php elseif($row['status'] == 'rejected'): ?>
                <p style="color: #f44336;">This claim was not approved by the finder.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center; margin-top:20px; color:#777;">You have not submitted any claims yet.</p>
<?php endif; ?>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
</script>

</body>
</html>
