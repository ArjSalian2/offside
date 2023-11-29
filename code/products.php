<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
    
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Products </title>
        <link rel="stylesheet" href="product-style.css">
    </head>

    <body>
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
                <form action="" method ="GET">

                    <h3>Gender</h3>
                    <?php
                        $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");
                        $genders = $db->query("SELECT DISTINCT product_gender FROM products ORDER BY product_gender ASC");
                        foreach($genders as $gender) {
                        ?>
                            <input type="checkbox" id="<?= $gender[0];?>" name="gender[]" value="<?=$gender[0];?>">
                            <label for="<?= $gender[0]?>"> <?= strval($gender[0]) ?></label> <br>
                        <?php
                        }
                    ?>

                    <h3>Colour</h3>
                    <?php
                        $colours = $db->query("SELECT DISTINCT product_colour FROM products ORDER BY product_colour ASC");
                        foreach($colours as $colour) {
                        ?>
                            <input type="checkbox" id="<?= $colour[0];?>" name="colour[]" value="<?=$colour[0];?>">
                            <label for="<?= $colour[0]?>"> <?= strval($colour[0]) ?></label> <br>
                        <?php
                        }
                    ?>

                    <h3>Category</h3>
                    <?php
                        $categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category ASC");
                        foreach($categories as $category) {
                        ?>
                            <input type="checkbox" id="<?= $category[0];?>" name="category[]" value="<?=$category[0];?>">
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
                            <div class="product-card" id="<?=$product["product_id"]?>"> <?= $product["product_name"] ?> 
                            <!-- Add basket functionality here -->
                            

                            <!-- ----------------------------- -->
                            </div>
                        <?php
                        } 
                    }
                    else {                    
                        $products = $db->query("SELECT * FROM products"); 
                        foreach($products as $product) {
                        ?>
                            <div class="product-card" id="<?=$product["product_id"]?>"> <?= $product["product_name"] ?> 
                            
                            <!-- Add basket functionality here -->


                            <!-- ----------------------------- -->
                            </div>
                        <?php
                        }

                    }

                ?>
            </div>
        </main>
    </body>
