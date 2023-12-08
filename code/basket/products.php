<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" />
    <title> Products </title>
    <link rel="stylesheet" href="product-style.css">
</head>

<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse justify-content-end navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav  mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Current User
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="my_orders.php">My orders</a></li>
                            </ul>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>
    </header>
    <main>

        <h1>
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
            <form action="" method="GET">

                <h3>Gender</h3>
                <?php
                $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
                $genders = $db->query("SELECT DISTINCT product_gender FROM products ORDER BY product_gender ASC");
                foreach ($genders as $gender) {
                    ?>
                    <input type="checkbox" id="<?= $gender[0]; ?>" name="gender[]" value="<?= $gender[0]; ?>">
                    <label for="<?= $gender[0] ?>">
                        <?= strval($gender[0]) ?>
                    </label> <br>
                    <?php
                }
                ?>

                <h3>Colour</h3>
                <?php
                $colours = $db->query("SELECT DISTINCT product_colour FROM products ORDER BY product_colour ASC");
                foreach ($colours as $colour) {
                    ?>
                    <input type="checkbox" id="<?= $colour[0]; ?>" name="colour[]" value="<?= $colour[0]; ?>">
                    <label for="<?= $colour[0] ?>">
                        <?= strval($colour[0]) ?>
                    </label> <br>
                    <?php
                }
                ?>

                <h3>Category</h3>
                <?php
                $categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category ASC");
                foreach ($categories as $category) {
                    ?>
                    <input type="checkbox" id="<?= $category[0]; ?>" name="category[]" value="<?= $category[0]; ?>">
                    <label for="<?= $category[0] ?>">
                        <?= strval($category[0]) ?>
                    </label> <br>
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
                    $genderchecked = "'" . implode("','", $genderchecked) . "'";
                } else {
                    $genders = $db->query("SELECT DISTINCT product_gender FROM products ORDER BY product_gender ASC");
                    foreach ($genders as $gender) {
                        array_push($genderchecked, $gender[0]);
                    }
                    $genderchecked = "'" . implode("','", $genderchecked) . "'";
                }


                if (isset($_GET["colour"])) {

                    $colourchecked = $_GET["colour"];
                    $colourchecked = "'" . implode("','", $colourchecked) . "'";
                } else {
                    $colours = $db->query("SELECT DISTINCT product_colour FROM products ORDER BY product_colour ASC");
                    foreach ($colours as $colour) {
                        array_push($colourchecked, $colour[0]);
                    }
                    $colourchecked = "'" . implode("','", $colourchecked) . "'";
                }


                if (isset($_GET["category"])) {

                    $categorychecked = $_GET["category"];
                    $categorychecked = "'" . implode("','", $categorychecked) . "'";
                } else {
                    $categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category ASC");
                    foreach ($categories as $category) {
                        array_push($categorychecked, $category[0]);
                    }
                    $categorychecked = "'" . implode("','", $categorychecked) . "'";
                }


                $products = $db->query("SELECT * FROM products WHERE product_gender IN ($genderchecked) AND product_colour IN ($colourchecked) AND product_category IN ($categorychecked)");
                foreach ($products as $product) {
                    ?>
                    <div class="product-card" id="<?= $product["product_id"] ?>">
                        <?= $product["product_name"] ?>
                        <!-- Add basket functionality here -->
                        <!-- adding product to cart when click -->
                        <button class="add-to-cart-btn" data-product-id="<?= $product["product_id"] ?>">Add to Cart</button>
                        <!-- ----------------------------- -->
                    </div>
                    <?php
                }
            } else {
                $products = $db->query("SELECT * FROM products");
                foreach ($products as $product) {
                    ?>
                    <div class="product-card" id="<?= $product["product_id"] ?>">
                        <?= $product["product_name"] ?>

                        <!-- Add basket functionality here -->
                        <!-- adding product to cart when click -->
                        <button class="add-to-cart-btn" data-product-id="<?= $product["product_id"] ?>">Add to Cart</button>


                        <!-- ----------------------------- -->
                    </div>
                    <?php
                }

            }

            ?>
        </div>
    </main>
    <script src="script.js"></script>
</body>