<?php 
// Dummy actions (for demo only)
if(isset($_GET['action'])){
    $message = "Action performed: " . htmlspecialchars($_GET['action']);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Claims</title>

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

/* PROFILE HEADER (SIDEBAR) */
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

.profile-content a{
    text-decoration:none;
    color:white;
}

.profile-content a:visited{
    color:white;
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

/* MAIN CONTAINER */
.container{
    padding:20px;
}

/* TITLE */
h1{
    text-align:center;
    color:#0b3d70;
    margin-bottom:15px;
}

/* PROFILE TOP */
.profile-top{
    text-align:center;
    margin-bottom:20px;
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

/* TOP BUTTON ROW */
.button-row{
    display:flex;
    justify-content:center;
    gap:10px;
    margin:20px 0 25px;
}

.button-row a{
    padding:10px 15px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    font-size:13px;
    color:white;
}

.primary-btn{
    background:#0b3d70;
}

.gray-btn{
    background:#777;
}

/* CLAIM CARDS */
.claim-card{
    background:white;
    border:2px solid #0b3d70;
    border-radius:12px;
    padding:15px;
    margin-bottom:20px;
}

.claim-card h3{
    color:#0b3d70;
    margin-bottom:10px;
}

/* BUTTON GROUP */
.button-group{
    margin-top:15px;
    display:flex;
    gap:10px;
}

.button-group a{
    flex:1;
    text-align:center;
    padding:10px 0;
    border-radius:6px;
    font-size:14px;
    text-decoration:none;
    color:white;
    font-weight:bold;
}

.accept{ background:#4CAF50; }
.reject{ background:#f44336; }
.message{ background:#e0a23b; }

.success{
    text-align:center;
    color:green;
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
            <div class="profile-name">Francine Panganiban</div>
            <div class="profile-email">fastodomingo@student.hau.edu.ph</div>
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

    <a href="index.php" class="menu-item">
        <img src="image/out.png"> Log Out
    </a>

</div>

<div class="container">

<h1>View Claims</h1>

<div class="profile-top">
    <img src="image/user.png" class="profile-main-pic">
    <h2>Francine Panganiban</h2>
    <p class="email">fastodomingo@student.hau.edu.ph</p>
</div>

<!-- BUTTONS MOVED TO TOP -->
<div class="button-row">
    <a href="profile.php" class="gray-btn">My Listed Items</a>
    <a href="viewclaims.php" class="primary-btn">View Claims</a>
    <a href="myclaims.php" class="gray-btn">My Claims</a>
</div>

<?php if(isset($message)): ?>
<div class="success"><?php echo $message; ?></div>
<?php endif; ?>

<!-- CLAIM 1 -->
<div class="claim-card">
    <h3>Claims for O1C</h3>
    <p><strong>Claimant:</strong> Fendi N. Cruz</p>
    <p><strong>Email:</strong> fjccruz@student.hau.edu.ph</p>
    <p><strong>Submitted:</strong> February 15, 2026</p>
    <br>
    <p><strong>Answers:</strong></p>
    <p>- Brand: Seiko</p>
    <p>- Cards: 3</p>
    <p>- ID Inside: Yes</p>

    <div class="button-group">
        <a href="?action=Accepted" class="accept">Accept</a>
        <a href="?action=Rejected" class="reject">Reject</a>
        <a href="?action=Message Sent" class="message">Message</a>
    </div>
</div>

<!-- CLAIM 2 -->
<div class="claim-card">
    <h3>Claims for O1B</h3>
    <p>Gabriel C. Bondoc – Pending – Submitted February 20, 2026</p>
    <p>Lauren A. David – Pending – Submitted February 22, 2026</p>
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
