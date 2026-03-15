<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ACCEPT CLAIM */
if(isset($_GET['accept'])){
    $claim_id = intval($_GET['accept']);

    $claim = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT claims.*, items.posted_by
        FROM claims
        JOIN items ON claims.item_id = items.id
        WHERE claims.id='$claim_id'
    "));

    if($claim && $claim['posted_by'] == $user_id){
        $item_id = $claim['item_id'];
        mysqli_query($conn,"UPDATE claims SET status='approved' WHERE id='$claim_id'");
        mysqli_query($conn,"UPDATE items SET status='claimed' WHERE id='$item_id'");
        mysqli_query($conn,"UPDATE claims SET status='rejected' WHERE item_id='$item_id' AND id!='$claim_id'");
    }
}

/* REJECT CLAIM */
if(isset($_GET['reject'])){
    $claim_id = intval($_GET['reject']);

    $claim = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT claims.*, items.posted_by
        FROM claims
        JOIN items ON claims.item_id = items.id
        WHERE claims.id='$claim_id'
    "));

    if($claim && $claim['posted_by'] == $user_id){
        mysqli_query($conn,"UPDATE claims SET status='rejected' WHERE id='$claim_id'");
    }
}

/* GET CLAIMS FOR ITEMS POSTED BY USER */
$query = "
SELECT claims.*, items.item_name, items.id AS item_code,
users.fullname, users.email
FROM claims
JOIN items ON claims.item_id = items.id
JOIN users ON claims.user_id = users.ID
WHERE items.posted_by='$user_id'
ORDER BY claims.created_at DESC
";

$result = mysqli_query($conn,$query);

/* GROUP CLAIMS BY ITEM */
$claims_by_item = [];

while($row = mysqli_fetch_assoc($result)){
    $claims_by_item[$row['item_id']][] = $row;
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

/* PAGE TITLE */
h1{
    text-align:center;
    font-size:28px;
    font-weight:bold;
    color:#0b3d70;
    margin-top:10px;
    margin-bottom:15px;
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
    color:white;
}

.primary-btn{
    background:#0b3d70;
}

.gray-btn{
    background:#777;
}

/* DESCRIPTION/SUBTITLE */
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

.claim-card h3{
    color:#0b3d70;
    margin-bottom:10px;
}

.claim-card p{
    margin-bottom:6px;
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
            <div class="profile-name"><?php echo $_SESSION['fullname']; ?></div>
            <div class="profile-email"><?php echo $_SESSION['email']; ?></div>
            </a>
        </div>
    </div>

    <a href="home.php" class="menu-item"><img src="image/home.png"> Home</a>
    <a href="browse.php" class="menu-item"><img src="image/lost.png"> Browse</a>
    <a href="list.php" class="menu-item"><img src="image/list.png"> List</a>
    <a href="claim.php" class="menu-item"><img src="image/found.png"> Claim</a>
    <a href="profile.php" class="menu-item"><img src="image/profile.png"> Profile</a>
    <a href="contactus.php" class="menu-item"><img src="image/contact.png"> Contact Us</a>
    <a href="logout.php" class="menu-item"><img src="image/out.png"> Log Out</a>
</div>

<div class="container">

<h1>View Claims</h1>

<div class="profile-top">
    <img src="image/user.png" class="profile-main-pic">
    <h2><?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
    <p class="email"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
</div>

<div class="button-row">
    <a href="profile.php" class="gray-btn">My Listed Items</a>
    <a href="viewclaims.php" class="primary-btn">View Claims</a>
    <a href="myclaims.php" class="gray-btn">My Claims</a>
</div>

<p class="subtitle">Review claims submitted for your listed items.</p>

<?php if(isset($message)): ?>
<div class="success"><?php echo $message; ?></div>
<?php endif; ?>

<?php if(empty($claims_by_item)): ?>
    <p style="text-align:center;margin-top:30px;">No claims yet for your listed items.</p>
<?php endif; ?>

<?php foreach($claims_by_item as $item_id => $claims): ?>
<div class="claim-card">
    <h3>Claims for FI-<?php echo $claims[0]['item_code']; ?></h3>

    <?php foreach($claims as $claim): ?>
        <p><strong>Claimant:</strong> <?php echo htmlspecialchars($claim['fullname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($claim['email']); ?></p>
        <p><strong>Submitted:</strong> <?php echo date("F d, Y", strtotime($claim['created_at'])); ?></p>

        <br>
        <p><strong>Answers:</strong></p>
        <p>- <?php echo htmlspecialchars($claim['answer1']); ?></p>
        <p>- <?php echo htmlspecialchars($claim['answer2']); ?></p>
        <p>- <?php echo htmlspecialchars($claim['answer3']); ?></p>

        <?php if($claim['status']=="pending"): ?>
            <div class="button-group">
                <a href="?accept=<?php echo $claim['id']; ?>" class="accept">Accept</a>
                <a href="?reject=<?php echo $claim['id']; ?>" class="reject">Reject</a>
                <a href="https://outlook.live.com/mail/0/deeplink/compose?to=<?php echo urlencode($claim['email']); ?>&subject=<?php echo urlencode('FoundIt Claim for Item FI-'.$claim['item_code']); ?>"
class="message" target="_blank">
Message
</a>
            </div>
        <?php else: ?>
            <p><strong>Status:</strong>
                <?php if($claim['status']=="approved"): ?>
                    <span style="color:green; font-weight:bold;">Approved</span>
                <?php elseif($claim['status']=="rejected"): ?>
                    <span style="color:red; font-weight:bold;">Rejected</span>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <?php if (count($claims) > 1 && $claim !== end($claims)): ?>
            <hr style="margin: 20px 0; border: 0; border-top: 1px dashed #ccc;">
        <?php endif; ?>

    <?php endforeach; ?>
</div>
<?php endforeach; ?>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
</script>

</body>
</html>