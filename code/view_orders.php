<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $userId = null;  
} else {
    $userId = $_SESSION["user_id"];
}

// Connect to the database
require_once('user_files/connection.php');

$isAdmin = false;

if (!isset($_SESSION['user_id'])) {
    $userId = null;  
} else {
    $userId = $_SESSION["user_id"];
    $stmtUser = $db->prepare("SELECT * FROM users WHERE userID = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    // Check if the user is an admin
    $isAdmin = ($user['user_type'] == 0);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="homepage-img/logo.png">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="view-orders-style.css">
    <link rel="stylesheet" href="nav-styles.css">
    <title>My Orders</title>
</head>



<script>
    searchParam = new URLSearchParams(window.location.search);
    url = 'search.php' + '?' +searchParam;
    if (searchParam.has("search-term")) {
        window.location.href = url;
    }

</script>


<header>

    <div class="logo"> <!--Hadeeqah -The logo for top of page-->
        <a href="/offside/index.php">
            <img src="homepage-img/logo.png" alt="Offside Logo">
        </a>
    </div>

    <div class="top-right-nav"> <!-- Hadeeqah- Updated the nav bar -->
        <div id="nav1">

            <?php if ($isAdmin): ?>
            <a href="Admin Inventory/dashboard.php">Admin</a>
            <?php endif; ?>

            <a href="about.php">About Us</a>
            <a href="basket/contact.php">Contact Us</a>
            <a href="user_files/login.php">Log In</a>
            <a href="user_files/user_details.php">Account details</a>
            <a href="view_orders.php">My orders</a>

        </div>
    </div>


</header>
<hr>

<!-- nav2-dima -->
<div id="nav2">
    <div class="nav2-center">
        <a href="products.php?gender%5B%5D=womens">Women</a>
        <a href="products.php?gender%5B%5D=mens">Men</a>
        <a href="products.php?category%5B%5D=accessories">Accessories</a>
    </div>

    <div class="nav2-right">
        <div id="search">
            <form>
                <input type="text" name="search-term" placeholder="Search">
                <input type="submit" value="Enter">
            </form>
        </div>
        <div id="basket-icon">
            <a href="new_cart.php"><img src="homepage-img/basket-icon.png" alt="Basket"></a>
        </div>
    </div>
</div>      

<body>
    <div id="orders-div">
        <h1 id="orderTitle"> My Orders </h1>
        <div id="orders-grid">
            <?php
            if (!isset($_SESSION['user_id'])) {
                //$userId = null;  
            } else {
                //$userId = $_SESSION["user_id"];           
            $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
            $totalPrice = 0;

            $stmt = $db->prepare("SELECT * FROM orders WHERE UserID=?");
            $stmt->execute([$userId]);
            $orders = $stmt->fetchAll();

            
            
            foreach ($orders as $order) {
                $stmt = $db->prepare("SELECT * FROM orderstatus WHERE StatusID=?");
                $stmt->execute([$order["OrderStatus"]]);
                $orderStatus = $stmt->fetch();
            ?>
                    <div class="order-card"> 
                        <div class="grid-container">
                            <p class="order_date"> Order placed: <?= $order["OrderDate"] ?></p>
                            <p class="order_price"> Order Total: £<?= $order["TotalAmount"] ?></p>
                            <p class="order_id"> Order ID:  <?= $order["OrderID"] ?></p>
                        </div>
                        <p class="order-info"> Status: <?= $orderStatus["StatusName"] ?></p>
                        <a class="order-info" href="order-info.php?id=<?= $order["OrderID"] ?>"> View ordered products</a>
                    </div>
                <?php
            }
            }
            if (!isset($_SESSION['user_id'])) {
                //$userId = null;
                ?>
                <div id="sign-in-div">
                <p>Sign in</p>
                </div>
                <?php
            } 
            ?>

    </div>
</body>