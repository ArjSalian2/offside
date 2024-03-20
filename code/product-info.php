<?php
// Start the session
session_start();

if (!isset($_SESSION['user_id'])) {
    $userId = null;  
} else {
    $userId = $_SESSION["user_id"];
}

$productID = $_GET["id"];
$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
$stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
$stmt->execute([$productID]);
$productRecord = $stmt->fetch();

$stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="homepage-img/logo.png">
    <title> Products </title>
    <link rel="stylesheet" href="product-info-style.css">
    <link rel="stylesheet" href="nav-styles.css">
</head>

<script>


    searchParam = new URLSearchParams(window.location.search);
    url = 'search.php' + '?' +searchParam;
    if (searchParam.has("search-term")) {
        window.location.href = url;
    }

    function addToCart(productIdParam, userIdParam) {
        productIdToAdd = productIdParam;
        userID = userIdParam;
        if(userID != null) {
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "addToBasketDB.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("prodID="+productIdToAdd + "&userID="+userID);
        }

    }


    function submitReview() {

        form = document.getElementById('form');
        fieldValue = form.review_message.value;

        document.getElementById("product-name").innerHTML = fieldValue;
        var userID = <?php echo json_encode($userId); ?>;
        var productID = <?php echo json_encode($productID); ?>;

        if (fieldValue != null) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("product-name").innerHTML = this.responseText;
                
            }

            xhttp.open("POST", "submit-review.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("prodID="+productID + "&userID="+userID + "&review="+fieldValue);
            form.reset();
            window.location.reload();
        }

        
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById("form").addEventListener("submit", function(e) {
            e.preventDefault() // Cancel the default action
            submitReview();
        });
    });



</script>

<header>

    <div class="logo"> <!--Hadeeqah -The logo for top of page-->
        <a href="/offside/index.html">
            <img src="homepage-img/logo.png" alt="Offside Logo">
        </a>
    </div>

    <div class="top-right-nav">
        <div id="nav1">
            <a href="about.html">About Us</a>
            <a href="basket/contact.php">Contact Us</a>
            <a href="user_files/login.php">Log In</a>
            <a href="user_files/user_details.php">Account details</a>
            <a href="basket/my_orders.php">My orders</a>
        </div>
    </div>

</header>


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
<div id="banner">
    <h2> Free Delivery & Returns</h2>
    <p> Offside members get free delivery and 60-day returns</p>
</div>

<body>
    <div class="container">

        <div class="left-column">
            <img src="product_img/<?=$productRecord["ImageURL"] ?>">
        </div>

        <div class="right-column">
            <div class="product-description">
                <h1 id="product-name"><?=$productRecord["product_name"] ?></h1>
                <h3 class="stock"> <?="Only " .$productRecord["StockLevel"] . " in stock"?> </h3>
                <p class="info"><?=$productRecord["product_gender"] ?></p>
                <p class="info"><?=$productRecord["product_category"] ?></p>
                <p class="info">£<?=$productRecord["product_price"] ?></p>
                <p class="description-title">Description:</p>
                <p ><?=$productRecord["Description"] ?></p>
                <button onclick="addToCart(<?= $productID?>, <?= $userId?>)" class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>



    </div>
    
        <div class="review-div">
            <?php
            $hasOrdered = FALSE;
            

            $stmt = $db->prepare("SELECT * FROM orders WHERE UserID=?");
            $stmt->execute([$userId]);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($orders as $order) {
                $stmt = $db->prepare("SELECT * FROM order_items WHERE OrderID=? AND ProductID=?");
                $stmt->execute([$order["OrderID"], $productID]);
                $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($orderItems as $orderItem) {
                    if ($orderItem["ProductID"] == $productID) {
                        $hasOrdered = TRUE;
                    }
                }
            }
            if ($hasOrdered) {
                ?>
                <form id="form">
                <label for="review-area">Leave a review:</label> <br>
                <textarea id="review-area" name="review_message" placeholder=""  required></textarea><br>

                <input id="submit-review-btn" type="submit">
                </form>
                <?php
            } else {
                ?>
                <p>Cannot review unless product is ordered</p>
                <?php
            }


            ?>
            <?php
         
            $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
            $totalPrice = 0;

            $stmt = $db->prepare("SELECT * FROM reviews WHERE product_id=?");
            $stmt->execute([$productID]);
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            foreach ($reviews as $review) {
                $stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
                $stmt->execute([$review["product_id"]]);
                $productRecord = $stmt->fetch();

                $stmt = $db->prepare("SELECT * FROM users WHERE UserID=?");
                $stmt->execute([$review["UserID"]]);
                $userRecord = $stmt->fetch();
            ?>
                    <div class="review-card">  
                        <p class="user_name">Name: <?= $userRecord["First Name"] ?></p>
                        <p class="review_comment"> Review: <?= $review["Comment"] ?></p>

                    </div>
                <?php
            }
            
            ?>
        </div>

</body>