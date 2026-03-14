<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['item_id'])){
    header("Location: browse.php");
    exit();
}

$item_id = intval($_GET['item_id']);
$user_id = $_SESSION['user_id'];

/* GET ITEM DETAILS */
$item_query = mysqli_query($conn, "SELECT * FROM items WHERE id='$item_id'");
$item = mysqli_fetch_assoc($item_query);

if(!$item){
    header("Location: browse.php");
    exit();
}

/* HANDLE CLAIM SUBMIT */
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $answer1 = mysqli_real_escape_string($conn, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($conn, $_POST['answer2']);
    $answer3 = mysqli_real_escape_string($conn, $_POST['answer3']);

    $insert = "INSERT INTO claims 
               (item_id, user_id, answer1, answer2, answer3, status)
               VALUES
               ('$item_id', '$user_id', '$answer1', '$answer2', '$answer3', 'pending')";

    mysqli_query($conn, $insert);

    header("Location: approved.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Claim Item</title>

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

.menu-item:hover{
    background:#e6e6e6;
}

/* MAIN CONTAINER */
.container{
    padding:20px;
}

h1{
    text-align:center;
    color:#0b3d70;
    margin-bottom:20px;
}

/* SEARCH BAR */
.search-box{
    background:white;
    border-radius:30px;
    padding:12px 20px;
    margin-bottom:20px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.search-box input{
    width:100%;
    border:none;
    outline:none;
    font-size:14px;
}

/* ITEM SUMMARY */
.summary{
    background:white;
    border-radius:12px;
    padding:15px;
    margin-bottom:20px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.summary h3{
    color:#0b3d70;
    margin-bottom:10px;
}

/* INSTRUCTION BOX */
.instructions{
    text-align:center;
    background:#e9eef3;
    padding:20px;
    border-radius:10px;
    margin-bottom:25px;
    font-size:14px;
    line-height:1.6;
}

.instructions strong{
    color:#0b3d70;
}

/* QUESTIONS */
.question{
    margin-bottom:20px;
}

.question label{
    font-weight:bold;
    color:#0b3d70;
    display:block;
    margin-bottom:5px;
}

textarea{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    resize:none;
    font-size:14px;
}

/* SUBMIT BUTTON */
.submit-btn{
    width:100%;
    padding:14px;
    background:#2d5fdb;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    margin-top:10px;
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

<div class="container">

<h1>Claim</h1>

<div class="search-box">
    <input type="text" placeholder="Enter Item ID here...">
</div>

<div class="summary">
    <h3>Item Summary</h3>
    <p><strong>Item Name:</strong> <?php echo $item['item_name']; ?></p>
    <p><strong>Location Found:</strong> <?php echo $item['location_found']; ?></p>
    <p><strong>Date Found:</strong> <?php echo $item['date_found']; ?></p>
</div>

<div class="instructions">
    To claim this item, please answer the verification questions below accurately.<br><br>
    Your responses will be reviewed by the finder.<br><br>
    Submitting this form <strong>does not automatically approve</strong> your claim.
</div>

<form method="POST">

<div class="question">
    <label>Question 1: Describe the item's exact appearance (color, size, markings).</label>
    <textarea name="answer1" rows="3" required></textarea>
</div>

<div class="question">
    <label>Question 2: When and where did you last see this item?</label>
    <textarea name="answer2" rows="3" required></textarea>
</div>

<div class="question">
    <label>Question 3: Mention any unique identifiers (brand, scratches, stickers, contents, etc.).</label>
    <textarea name="answer3" rows="3" required></textarea>
</div>

<button type="submit" class="submit-btn">Submit Claim</button>

</form>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
</script>

</body>
</html>
