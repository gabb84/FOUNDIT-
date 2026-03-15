<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$search = "";
$category = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if(isset($_GET['category'])){
    $category = mysqli_real_escape_string($conn, $_GET['category']);
}

$query = "SELECT * FROM items WHERE status='available' AND approval_status='approved'";

if($search != ""){
    $query .= " AND item_name LIKE '%$search%'";
}

if($category != ""){
    $query .= " AND category='$category'";
}

$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Browse | FoundIt</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#e6e6e6;
    display:flex;
    justify-content:center;
}

.app{
    width:100%;
    max-width:430px;
    background:#f5f7fb;
    min-height:100vh;
    position:relative;
}

/* ================= HEADER ================= */
header{
    top:0;
    background:#f5f7fb;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
}

.logo{
    width:150px;
}

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

/* ================= SIDEBAR ================= */
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
    background:url("image/menubg.png") center/cover no-repeat;
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

/* ================= CONTENT ================= */

.content{
    padding:20px 20px 40px 20px;
}

.page-title{
    text-align:center;
    font-size:30px;
    font-weight:bold;
    color:#0b3d70;
    margin-bottom:20px;
}

/* SEARCH */
.search{
    position:relative;
    margin-bottom:30px;
}

.search input{
    width:100%;
    padding:14px 45px 14px 18px;
    border-radius:14px;
    border:2px solid #0b3d70;
    font-size:14px;
    background:white;
}

.search-icon{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    font-size:18px;
    color:#0b3d70;
}

/* CATEGORY GRID */
.category-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.category-header h2{
    color:#0b3d70;
}

.others{
    font-size:14px;
    color:#888;
}

.categories{
    display:grid;
    grid-template-columns:repeat(3, 1fr); 
    gap:16px;
    margin-bottom:35px;
}

.category-box{
    background:#1f4f82;
    border-radius:18px;
    aspect-ratio: 1/1;          
    display:flex;               
    flex-direction:column;      
    align-items:center;        
    justify-content:center;     
    padding:10px;
    text-align:center;
}

.category-box img{
    width:45px;
    height:45px;
    object-fit:contain;   
    margin-bottom:8px;
}

.category-box img{
    width:45px;
    height:45px;
    object-fit:contain;   
    margin-bottom:8px;
}

.category-box span{
    color: white;       
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
}

/* POSTS */
.latest-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

.latest-header h2{
    color:#0b3d70;
}

.post-card{
    display:flex;
    align-items:center;
    background:white;
    padding:14px;
    border-radius:18px;
    margin-bottom:18px;
    box-shadow:0 6px 14px rgba(0,0,0,0.08);
}

.post-image{
    width:75px;
    height:75px;
    border-radius:14px;
    margin-right:15px;
    object-fit:cover;
}

.post-details{
    flex:1;
}

.post-details h3{
    font-size:16px;
    font-weight:bold;
    color:#0b3d70;
    margin-bottom:4px;
}

.post-details p{
    font-size:12px;
    color:#444;
}

.claim-btn{
    margin-top:8px;
    padding:6px 14px;
    background:#1f4f82;
    color:white;
    border:none;
    border-radius:8px;
    font-size:12px;
    font-weight:bold;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="app">

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

<div class="content">

    <div class="page-title">Browse</div>

    <form method="GET" class="search">
        <input type="text" name="search" placeholder="Search item list">
        <button type="submit" class="search-icon">&#128269</button>
    </form>

    <div class="category-header">
    <h2>Categories</h2>
    <a href="browse.php?category=Others" class="others">Others</a>
    </div>

    <div class="categories">

        <a href="browse.php?category=Bottle">
        <div class="category-box">
        <img src="image/bottle.jpg">
        <span>BOTTLE</span>
        </div>
        </a>

        <a href="browse.php?category=Umbrella">
        <div class="category-box">
        <img src="image/payong.jpg">
        <span>UMBRELLA</span>
        </div>
        </a>

        <a href="browse.php?category=Bag">
        <div class="category-box">
        <img src="image/bag.jpg">
        <span>BAG</span>
        </div>
        </a>

        <a href="browse.php?category=ID">
        <div class="category-box">
        <img src="image/id.jpg">
        <span>ID</span>
        </div>
        </a>

        <a href="browse.php?category=Wallet">
        <div class="category-box">
        <img src="image/pitaka.jpg">
        <span>WALLET</span>
        </div>
        </a>

        <a href="browse.php?category=Fan">
        <div class="category-box">
        <img src="image/fan.jpg">
        <span>FAN</span>
        </div>
        </a>

    </div>

    <div class="latest-header">
        <h2>Latest Posts</h2>
        <div style="font-size:14px;color:#888;">Sort By ▲</div>
    </div>

<?php if(mysqli_num_rows($result) > 0): ?>

    <?php while($row = mysqli_fetch_assoc($result)): ?>

        <div class="post-card">
            <img src="uploads/<?php echo $row['image']; ?>" class="post-image">

            <div class="post-details">
                <h3><?php echo $row['item_name']; ?></h3>

                <p>
                    Item ID: FI-<?php echo $row['id']; ?><br>
                    Location: <?php echo $row['location_found']; ?><br>
                    Date: <?php echo $row['date_found']; ?>
                </p>

                <button class="claim-btn"
                    onclick="location.href='claim.php?item_id=<?php echo $row['id']; ?>'">
                    Claim it!
                </button>
            </div>
        </div>

    <?php endwhile; ?>

<?php else: ?>
    <p>No items available.</p>
<?php endif; ?>

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
