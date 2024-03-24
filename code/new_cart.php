<?php
session_start();

// Connect to the database
require_once('<user_files>/connection.php');

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
    <link rel="stylesheet" href="new-cart-styles.css">
    <link rel="stylesheet" href="nav-styles.css">
    <title>Cart</title>
</head>



<script>
    searchParam = new URLSearchParams(window.location.search);
    url = 'search.php' + '?' +searchParam;
    if (searchParam.has("search-term")) {
        window.location.href = url;
    }

    function updateCart(buttonParam) {
        itemId = buttonParam.getAttribute("basket-item-id");
        cartAction = buttonParam.value;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("cartTitle").innerHTML = this.responseText;
            
        }
        xhttp.open("POST", "updateBasket.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("itemID="+itemId + "&cartAction="+cartAction);
        location.reload();
    }

    function submitOrder(userIdParam, totalPriceParam, basketIdParam) {
        userId = userIdParam;
        totalPrice = totalPriceParam
        basketId = basketIdParam
        outOfStock = false;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (this.responseText != "") {
                outOfStock = true;
            }
            if (outOfStock == false) {
                location.reload();
            } else {
                document.getElementById("stockMessageDiv").innerHTML = this.responseText;
            }
            
        }
        xhttp.open("POST", "submit_order.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("userID="+userId + "&totalPrice="+totalPrice + "&basketID="+basketId);


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
    <div id="basket-div">
        <h1 id="cartTitle"> Cart </h1>
        <p id="stockMessageDiv"> </p>
        <div id="cart-item-grid" >
            <?php
            if (!isset($_SESSION['user_id'])) {
                //$userId = null;  
            } else {
                //$userId = $_SESSION["user_id"];           
            $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
            $totalPrice = 0;

            $stmt = $db->prepare("SELECT * FROM shopping_basket WHERE UserID=?");
            $stmt->execute([$userId]);
            $allBaskets = $stmt->fetch();

            if ($allBaskets) {
            } else {
                echo "User has no basket";
                $stmt = $db->prepare("INSERT INTO shopping_basket (UserID) VALUES (?)");
                $stmt->execute([$userId]); 
                header("Refresh:0");
            }

            $stmt = $db->prepare("SELECT * FROM shopping_basket WHERE UserID=?");
            $stmt->execute([$userId]);
            $basket = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $basketID = $basket["BasketID"];

            $stmt = $db->prepare("SELECT * FROM shopping_basket_items WHERE BasketID=?"); 
            $stmt->execute([$basketID]);
            $basketProducts = $stmt->fetchAll();

            
            
            foreach ($basketProducts as $basketProduct) {
                $stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
                $stmt->execute([$basketProduct["ProductID"]]);
                $productRecord = $stmt->fetch();
                $totalPrice = $totalPrice + ($productRecord["product_price"] * $basketProduct["Quantity"])
            ?>
                    <div class="basket-item-card"> 
                        <img class="item_img" src="product_img/<?= $productRecord["ImageURL"] ?>">
                        <p class="item_name"> <?= $productRecord["product_name"] ?></p>
                        <p class="item_quantity"> Quantity: <?= $basketProduct["Quantity"] ?></p>
                        <button onclick="updateCart(this)" class="increase-btn" value="increase" basket-item-id="<?= $basketProduct["ShoppingBasketItemID"] ?>">+</button>
                        <button onclick="updateCart(this)" class="decrease-btn" value="decrease" basket-item-id="<?= $basketProduct["ShoppingBasketItemID"] ?>">-</button>
                        <button onclick="updateCart(this)" class="remove-btn" value="remove" basket-item-id="<?= $basketProduct["ShoppingBasketItemID"] ?>">Remove</button>

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
            } else {
            ?>
            
            <div id="summ-div">
                <p>Total: £<?= $totalPrice ?></p>
                <button onclick="submitOrder(<?=$userId?>, <?=$totalPrice?>, <?=$basketID?>)" class="checkout-btn">Checkout</button>
            </div>
            <?php
            }
            ?>
    </div>
</body>