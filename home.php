<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu Page</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:url("image/menubg.png") no-repeat center center fixed;
    background-size:cover;
    min-height:100vh;  
    overflow-y:auto;    
    position:relative;
    color:white;
}


/* HEADER */
header{
    position:absolute;
    top:0;
    width:100%;
    padding:20px;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    z-index:10;
}

/* HAMBURGER */
.hamburger{
    width:28px;
    cursor:pointer;
}

.hamburger div{
    height:4px;
    background:white;
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
    z-index:20;
    overflow-y:auto;
    padding:0;
}

.sidebar.active{
    right:0;
}

/* OVERLAY */
.menu-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    opacity:0;
    visibility:hidden;
    transition:0.3s;
    z-index:15;
}

.menu-overlay.active{
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

.profile-content{
    position:relative;
    z-index:2;
}

.profile-content a{
    all: unset;
    display:block;
    cursor:pointer;
}

.profile-pic{
    width:70px;
    height:70px;
    background:#ddd;
    border-radius:50%;
    margin-bottom:10px;
}

.profile-header::after{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.5);
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

/* LOGO SECTION */
.top-logo{
    text-align:center;
    padding-top:140px;
}

.top-logo img{
    width:90%;
    max-width:520px;
}

/* WHITE SECTION */
.bottom-section{
    background:white;
    margin-top:-40px;
    padding:40px 30px 80px;
    border-top-left-radius:40px;
    border-top-right-radius:40px;
    color:#333;
}

/* INFO IMAGE */
.info-image{
    text-align:center;
    margin-bottom:20px;
}

.info-image img{
    width:100%;
    max-width:500px;
}

/* TEXT */
.bottom-text{
    line-height:1.6;
    font-size:15px;
    margin-bottom:40px;
}

/* WHY SECTION */
.why-section{
    margin-top:0;
}

.why-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.why-title{
    font-size:25px;
    font-weight:bold;
    color:#0e3a5f;
    line-height:1.3;
    margin-bottom:20px;
}

.why-title img{
    width: 105%;
    max-width: 410px;
    height: auto;
    display: block;
    margin: 0 auto;
}

.why-text{
    font-size:14px;
    line-height:1.7;
}

.bottom-text{
    margin-bottom:10px;
}

/* HOW IT WORKS */
.how-wrapper{
    background:#0e3a5f;
    border-radius:30px;
    padding:25px 20px 35px;
    margin-top:20;
    color:white;  
}

/* White title attached INSIDE */
.how-title-box{
    background:white;
    color:#0e3a5f;
    text-align:center;
    font-weight:bold;
    padding:12px;
    border-radius:25px;
    margin-bottom:25px;
    letter-spacing:4px;
}

.how-item{
    margin-bottom:25px;
}

.how-heading{
    display:flex;
    align-items:center;
    margin-bottom:8px;
}

.how-heading span{
    font-weight:bold;
    font-size:15px;
    margin-right:10px;
}

.how-line{
    flex:1;
    height:2px;
    background:white;
    opacity:0.6;
}

.how-item p{

    font-size:14px;
    line-height:1.6;
}

.bottom-text{
    margin-bottom:10px;
}

/* MISSION & VISION */
.section{
    padding:20px;
    background:white;   
}

.mv{
    display:flex;
    justify-content:space-between;
    gap:20px;
}

.mv h2{
    font-size:24px;
    color:#1b4f72;   
    margin-bottom:10px;
}

.mv p{
    font-size:13px;
    line-height:1.6;
    text-align:justify;
    color:#000;     
}

.divider{
    width:2px;
    background:#1b4f72;
}


/* TEAM SECTION */
.team-section{
    position:relative;
    padding:30px 20px;
    text-align:center;
    color:white;
    overflow:hidden;
}

.team-section::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:url("image/menubg.png") center/cover no-repeat;
    z-index:0;
}

.team-section::after{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(14, 58, 95, 0.80);
    z-index:1;
}

.team-section *{
    position:relative;
    z-index:2;
    
}

.team-section h2{
    font-size:28px;
    font-weight:700;
    margin-bottom:15px;
}

.team-section p{
    font-size:13px;
    margin-bottom:20px;
    line-height:1.6;
}

.roles{
    font-size:12px;
    margin-bottom:20px;
    line-height:1.8;
}

.roles b{
    font-weight:600;
}

.team-img{
    width:100%;
    max-width:500px;
    border-radius:30px;
    margin:20px auto 0;
    display:block;
}

/* OVERLAY */
.menu-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    opacity:0;
    visibility:hidden;
    transition:0.3s;
    z-index:15;
}

.menu-overlay.active{
    opacity:1;
    visibility:visible;
}

.overlay.active{
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
    z-index:20;
    overflow-y:auto;
    padding:0;
}

.sidebar.active{
    right:0;
}

.logo{
    font-size:28px;
    font-weight:700;
    color:#1b4f72;
}

.logo span{
    color:#f4c430;
}

.menu{
    font-size:26px;
    color:#1b4f72;
    cursor:pointer;
}

/* ============================= */
/* NOTIFICATION BELL */
/* ============================= */

.notif-dropdown{
display:none;
position:absolute;
top:60px;
right:20px;
background:white;
width:260px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
z-index:1000;
overflow:hidden;
color:#333;
}

.notif-item{
padding:12px 15px;
border-bottom:1px solid #eee;
font-size:14px;
}

.notif-item:hover{
background:#f5f5f5;
}

.notif-empty{
padding:15px;
text-align:center;
color:#777;
}

/* ============================= */
/* FOOTER SECTION */
/* ============================= */

.footer-section{
    background:#f2f2f2;
    text-align:center;
    padding:30px 20px;
}

.footer-logo{
    width:180px;
    margin-bottom:15px;
}

.footer-desc{
    font-size:14px;
    margin-bottom:15px;
    color:#333;
}

.footer-links{
    font-size:14px;
    margin-bottom:15px;
}

.footer-links a{
    text-decoration:none;
    color:#0e3a5f;
    font-weight:600;
}

.footer-contact{
    font-size:13px;
    color:#555;
    line-height:1.6;
}

</style>
</head>

<body>

<header>

    <div class="header-right">

    <a href="notifications.php" class="bell">
    🔔

    <?php
    $notif_query = mysqli_query($conn,"
    SELECT COUNT(*) as total
    FROM claims
    JOIN items ON claims.item_id = items.id
    WHERE items.posted_by='".$_SESSION['user_id']."'
    AND claims.status='pending'
    ");

    $notif = mysqli_fetch_assoc($notif_query);

    if($notif['total'] > 0){
    echo "<span class='notif-badge'>".$notif['total']."</span>";
    }
    ?>
    </a>

    <div class="hamburger" onclick="toggleMenu()">
    <div></div>
    <div></div>
    <div></div>
    </div>

    </div>

    <div class="notif-dropdown" id="notifDropdown">

    <?php

    $claims_query = mysqli_query($conn,"
    SELECT users.fullname, items.item_name
    FROM claims
    JOIN items ON claims.item_id = items.id
    JOIN users ON claims.user_id = users.ID
    WHERE items.posted_by='".$_SESSION['user_id']."'
    AND claims.status='pending'
    ORDER BY claims.created_at DESC
    LIMIT 5
    ");

    if(mysqli_num_rows($claims_query) > 0){
    while($row = mysqli_fetch_assoc($claims_query)){

    echo "<div class='notif-item'>
    <strong>".$row['fullname']."</strong> claimed your <strong>".$row['item_name']."</strong>
    </div>";
    }
    }else{
    echo "<div class='notif-empty'>No new notifications</div>";
    }
    ?>
    </div>
</header>

<div class="menu-overlay" id="menuOverlay" onclick="toggleMenu()"></div>

<div class="sidebar" id="sidebar">

    <div class="profile-header">
        <div class="profile-content">
            <a href="menu.php">
                <img src="image/user.png" class="profile-pic">
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

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="admin/dashboard.php" class="menu-item">
        <img src="image/admin.png"> Admin Panel
        </a>
    <?php endif; ?>

    <a href="logout.php" class="menu-item">
        <img src="image/out.png"> Log Out
    </a>

</div>

<div class="top-logo">
    <img src="image/menulogo.png">
</div>

<div class="bottom-section">

    <div class="info-image">
        <img src="image/info.png">
    </div>

    <div class="bottom-text">
        FoundIt is a campus-exclusive lost and found web application developed for Holy Angel University. 
        It was created to provide a centralized and secure platform where students and staff can report lost items, 
        post found belongings, and reconnect with their rightful owners efficiently. 
        By requiring HAU email authentication, the system ensures that only legitimate members of the university 
        community can access and use the platform.
    </div>

    <!-- WHY SECTION -->
    <div class="why-section">
        <div class="why-title">
    <img src="image/why.png" alt="Why FoundIt Was Created">
</div>


        <div class="why-container">

            <div class="why-text">
                Losing personal belongings on campus is common, and traditional lost-and-found processes are often unorganized, slow, and difficult to track. FoundIt addresses these challenges by offering a structured digital system that improves accessibility, security, and communication. The platform features a hidden verification mechanism that helps validate ownership before claims are approved, reducing false claims and enhancing trust among users. In addition, a built-in notification system keeps users informed about claim requests and updates in real time.
            </div>
        </div>
    </div>

</div>

<!-- HOW IT WORKS SECTION -->
<div class="how-wrapper">

    <div class="how-title-box">
        HOW IT WORKS
    </div>

    <div class="how-item">
        <h4>List</h4>
        <p>
            If you find a lost item within Holy Angel University, you can post it in the List tab by providing the item’s public details and setting hidden verification questions. Once submitted, the system automatically generates a unique Item ID (e.g., FI-001), and the item becomes visible in the Browse tab.
        </p>
    </div>

    <div class="how-item">
        <h4>Browse</h4>
        <p>
            Students who have lost an item can explore the Browse tab to view all available found items. Each listing includes a unique ID and a claim button. Users may either click the claim button directly or manually enter the item ID in the Claim tab.
        </p>
    </div>

    <div class="how-item">
        <h4>Claim & Verify</h4>
        <p>
            To claim an item, the user must answer the hidden verification questions created by the finder. All claims are sent to the finder for review. The finder can accept, reject, or notify the claimant that they will reach out through HAU email. Multiple claims are allowed, but only one can be approved at a time. If necessary, the finder may reopen a claim before the item is archived.
        </p>
    </div>

</div>


<div class="container">


    <!-- MISSION & VISION -->
    <div class="section">
        <div class="mv">
            <div>
                <h2>Mission</h2>
                <p>
                    To provide Holy Angel University with a secure and structured digital lost-and-found platform 
                    that promotes accountability, honesty, and efficient item recovery within the campus community.
                </p>
            </div>

            <div class="divider"></div>

            <div>
                <h2>Vision</h2>
                <p>
                    To build a trusted campus environment where lost belongings are returned quickly and safely 
                    through a verification-based and community-driven system.
                </p>
            </div>
        </div>
    </div>

    <!-- TEAM SECTION -->
    <div class="team-section">
        <h2>Our Team</h2>

        <p>
            FoundIt is a web-based system developed by BSIT students of Holy Angel University as part of an academic project. 
            The team collaborated in system planning, development, database design, and user interface implementation to create 
            a functional and secure campus lost-and-found platform.
        </p>

        <div class="roles">
            <b>Project Leader</b> – Sto. Domingo, Francine Kimea A.<br>
            <b>Backend Developer</b> – Bondoc, Gabriel Joaquin C.<br>
            <b>Frontend Developer</b> – Garlin, Lauren A.<br>
            <b>Documentation Specialist</b> – Cruz, Jermae Fendi N.
        </div>

        <img src="image/founder.jpg" alt="Team Photo" class="team-img">

    </div>

</div>

<!-- FOOTER INFO SECTION -->
<div class="footer-section">

    <img src="image/logo.png" alt="FoundIt Logo" class="footer-logo">

    <p class="footer-desc">
        A campus-exclusive lost and found system for Holy Angel University.
    </p>

    <div class="footer-links">
        <a href="menu.php">Menu</a> |
        <a href="browse.php">Browse</a> |
        <a href="list.php">List</a> |
        <a href="claim.php">Claim</a> |
        <a href="profile.php">Profile</a>
        <a href="contactus.php">Contact Us</a> |    
    </div>

    <div class="footer-contact">
        ✉ foundit@hau.edu.ph<br>
        &#128205; Holy Angel University, Angeles City<br>
        © 2026 FoundIt | BSIT Academic Project
    </div>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("menuOverlay").classList.toggle("active");
}

function toggleNotif(event){

event.preventDefault();

let dropdown = document.getElementById("notifDropdown");

dropdown.style.display =
dropdown.style.display === "block" ? "none" : "block";

}

window.onclick = function(e){

if(!e.target.closest(".bell")){
document.getElementById("notifDropdown").style.display = "none";
}

};
</script>

</body>
</html>
