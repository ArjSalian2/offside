<?php
// Start the session
session_start();

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
    <title> Products </title>
    <link rel="stylesheet" href="product-style.css">
    <link rel="stylesheet" href="nav-styles.css">
</head>


<script>
    searchParam = new URLSearchParams(window.location.search);
    url = 'search.php' + '?' +searchParam;
    if (searchParam.has("search-term")) {
        window.location.href = url;
    }

    function viewProduct(buttonParam, userIDParam) {
        productIdToView = buttonParam.getAttribute("data-product-id");
        userID = userIDParam;
        productUrl = "product-info.php" + "?id=" + productIdToView;
        window.location.href = productUrl;
    }

    function addToCart(buttonParam, userIdParam) {
        productIdToAdd = buttonParam.getAttribute("data-product-id");
        userID = userIdParam;
        if(userID != null) {
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "addToBasketDB.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("prodID="+productIdToAdd + "&userID="+userID);
        }

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

<!-- Hadeeqah -->
<div id="banner">
    <h2> Free Delivery & Returns</h2>
    <p> Offside members get free delivery and 60-day returns</p>
</div>



    <body>
        <main>

            <h1 id="productTitle">
                Products
            </h1>

            <div id="shopBar">
                <div class="sortBy">
                    <h4>SORT BY</h4>
                    <select>
                        <option>Most Popular</option>
                        <option>Price (Lowest to Highest)</option>
                        <option>Price (Highest to Lowest)</option>
                        <option>Name (A to Z)</option>
                    </select>
                </div>
            </div>

            <aside id="filters">
                <h2>FILTER PRODUCTS</h2>
                <form action="" method ="GET">

                    <h3>Gender</h3>
                    <?php
                        $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
                        $genders = $db->query("SELECT DISTINCT product_gender FROM products ORDER BY product_gender ASC");
                        foreach($genders as $gender) {
                            $checked = [];
                            if(isset($_GET['gender'])){
                                $checked = $_GET['gender'];
                            }
                        ?>
                            <input type="checkbox" id="<?= $gender[0];?>" name="gender[]" value="<?=$gender[0];?>"  
                            <?php if(in_array($gender[0], $checked)){echo "checked";}  ?>>
                            <label for="<?= $gender[0]?>"> <?= strval($gender[0]) ?></label> <br>
                        <?php
                        }
                    ?>

                    <h3>Colour</h3>
                    <?php
                        $colours = $db->query("SELECT DISTINCT product_colour FROM products ORDER BY product_colour ASC");
                        foreach($colours as $colour) {
                            $checked = [];
                            if(isset($_GET['colour'])){
                                $checked = $_GET['colour'];
                            }
                        ?>
                            <input type="checkbox" id="<?= $colour[0];?>" name="colour[]" value="<?=$colour[0];?>"
                            <?php if(in_array($colour[0], $checked)){echo "checked";}  ?>>
                            <label for="<?= $colour[0]?>"> <?= strval($colour[0]) ?></label> <br>
                        <?php
                        }
                    ?>

                    <h3>Category</h3>
                    <?php
                        $categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category ASC");
                        foreach($categories as $category) {
                            $checked = [];
                            if(isset($_GET['category'])){
                                $checked = $_GET['category'];
                            }
                        ?>
                            <input type="checkbox" id="<?= $category[0];?>" name="category[]" value="<?=$category[0];?>"
                            <?php if(in_array($category[0], $checked)){echo "checked";}  ?>>
                            <label for="<?= $category[0]?>"> <?= strval($category[0]) ?></label> <br>
                        <?php
                        }
                    ?>

                    <button type="submit" class="submit-button">Apply Filters</button>
                </form>
            </aside>

            <div id="product-grid" class="grid-container">
                <?php
                    if ($_GET) {

                        $genderchecked = [];
                        $colourchecked = [];
                        $categorychecked = [];

                        if (isset($_GET["gender"])) {
                            $genderchecked = $_GET["gender"];
                            $genderchecked = "'".implode("','", $genderchecked)."'";
                        } else {
                            $genders = $db->query("SELECT DISTINCT product_gender FROM products ORDER BY product_gender ASC");
                            foreach($genders as $gender) {
                                array_push($genderchecked, $gender[0]);
                            }
                            $genderchecked = "'".implode("','", $genderchecked)."'";
                        }


                        if (isset($_GET["colour"])) {
                            
                            $colourchecked = $_GET["colour"];
                            $colourchecked = "'".implode("','", $colourchecked)."'";
                        } else {
                            $colours = $db->query("SELECT DISTINCT product_colour FROM products ORDER BY product_colour ASC");
                            foreach($colours as $colour) {
                                array_push($colourchecked, $colour[0]);
                            }
                            $colourchecked = "'".implode("','", $colourchecked)."'";
                        }


                        if (isset($_GET["category"])) {
                            
                            $categorychecked = $_GET["category"];
                            $categorychecked = "'".implode("','", $categorychecked)."'";
                        } else {
                            $categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category ASC");
                            foreach($categories as $category) {
                                array_push($categorychecked, $category[0]);
                            }
                            $categorychecked = "'".implode("','", $categorychecked)."'";
                        }


                        $products = $db->query("SELECT * FROM products WHERE product_gender IN ($genderchecked) AND product_colour IN ($colourchecked) AND product_category IN ($categorychecked)");
                        foreach($products as $product) {
                        ?>
                            <div class="product-card" id="<?=$product["product_id"]?>"> 
                            <div>
                                <img src="product_img/<?= $product["ImageURL"] ?>" style="height: 100%; width: 100%; object-fit: contain";>
                                </div>
                                <div class="product-card-info">
                                <p class="product-card-name"> <?= $product["product_name"] ?> </p>
                                <p class="product-card-gender"> <?= $product["product_gender"] ?> </p>
                                <p class="product-card-price">£<?= $product["product_price"] ?> </p>
                            </div>
                            <!-- Add basket functionality here -->
                            <button onclick="viewProduct(this, <?= $userId?>)" class="add-to-cart-btn" data-product-id="<?= $product["product_id"] ?>">View product</button>

                            <!-- ----------------------------- -->
                            </div>
                        <?php
                        } 
                    }
                    else {                    
                        $products = $db->query("SELECT * FROM products"); 
                        foreach($products as $product) {
                        ?>
                            <div class="product-card" id="<?=$product["product_id"]?>">
                                <div>
                                <img src="product_img/<?= $product["ImageURL"] ?>" style="height: 100%; width: 100%; object-fit: contain";>
                                </div>
                                <div class="product-card-info">
                                <p class="product-card-name"> <?= $product["product_name"] ?> </p>
                                <p class="product-card-gender"> <?= $product["product_gender"] ?> </p>
                                <p class="product-card-price">£<?= $product["product_price"] ?> </p>
                                </div>
                            <!-- Add basket functionality here -->
                                <button onclick="viewProduct(this, <?= $userId?>)" class="add-to-cart-btn" data-product-id="<?= $product["product_id"] ?>">View product</button>
                                

                            <!-- ----------------------------- -->
                            </div>
                        <?php
                        }

                    }

                ?>
            </div>
        </main>
       <!--<script src="basket/scripts.js"></script>-->
    </body>
