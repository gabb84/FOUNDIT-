<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location_found = mysqli_real_escape_string($conn, $_POST['location_found']);
    $date_found = mysqli_real_escape_string($conn, $_POST['date_found']);

    $posted_by = $_SESSION['user_id'];

    // Handle image safely
    $image_name = "";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image_name = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
    }

    $query = "INSERT INTO items 
              (item_name, category, description, location_found, date_found, image, posted_by)
              VALUES
              ('$item_name', '$category', '$description', '$location_found', '$date_found', '$image_name', '$posted_by')";

    mysqli_query($conn, $query);

    header("Location: browse.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>List Item</title>

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

/* TITLE */
h1{
    text-align:center;
    color:#0b3d70;
    margin-top:20px;
    margin-bottom:20px;
}

/* CONTAINER */
.container{
    max-width:600px;
    margin:0 auto 60px auto;
    padding:20px;
}

/* SECTION TITLE */
.section-title{
    background:#0b3d70;
    color:white;
    padding:12px 15px;
    font-weight:bold;
    margin-top:25px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    border:none;
    border-bottom:2px solid #ccc;
    margin-bottom:20px;
    font-size:14px;
    background:transparent;
}

/* DRAG AREA */
.drag-area{
    border:2px dashed #999;
    border-radius:12px;
    padding:30px;
    text-align:center;
    margin-bottom:20px;
    background:#fafafa;
    cursor:pointer;
    transition:0.3s;
}
.drag-area:hover{
    background:#e6f2ff;
    border-color:#0b3d70;
}
.drag-area img{
    width:70px;
    margin-bottom:10px;
}
.browse{
    color:#0b3d70;
    font-weight:bold;
    text-decoration:underline;
    cursor:pointer;
}

/* BUTTON */
button{
    width:100%;
    background:#0b3d70;
    color:white;
    padding:14px;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
    margin-top:15px;
}
.success{
    color:green;
    text-align:center;
    margin-bottom:15px;
    font-weight:bold;
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

    <a href="logout.php" class="menu-item">
        <img src="image/out.png"> Log Out
    </a>

</div>

<h1>List</h1>

<div class="container">

<div class="section-title">Public Information</div>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="item_name" placeholder="Item Name" required>
<input type="text" name="category" placeholder="Category (e.g. Wallet, Bottle)" required>
<input type="text" name="location_found" placeholder="Location Found" required>
<input type="date" name="date_found" required>
<textarea name="description" placeholder="Item Description" required></textarea>

<p><strong>Upload Image (Optional)</strong></p>

<div class="drag-area" id="dragArea">
    <input type="file" name="image" id="fileInput" hidden accept="image/*">
    <p><strong>Drag & drop images, or click to upload</strong></p>
    <p>or <span class="browse">browse files</span> on your computer</p>
</div>

<div class="section-title">Hidden Verification</div>

<p>Question 1: What is the color?</p>
<input type="text" name="answer1" required>

<p>Question 2: What brand?</p>
<input type="text" name="answer2" required>

<button type="submit">Post</button>

</form>
</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}

/* DRAG FUNCTION */
const dragArea = document.getElementById("dragArea");
const fileInput = document.getElementById("fileInput");

dragArea.addEventListener("click", () => fileInput.click());

fileInput.addEventListener("change", function(){
    if(this.files[0]){
        dragArea.querySelector("p").textContent = this.files[0].name;
    }
});
</script>

</body>
</html>
