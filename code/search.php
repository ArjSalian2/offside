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
  <link rel="stylesheet" href="searchstyle.css">
</head>


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


<!--SEARCH PAGE-->



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




      <form class="search_box" method="GET">
        <label class="search-label" for="search-term">Search:</label>
        <input type="text" name="search-term" id="search-term" />
        <input type="submit" value="Search" />
      </form>

      <script src="basket/script.js"></script>
</html>

<!--SEARCH PAGE END-->
                     
<?php

 $db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");                     

 

if (isset($_GET['search-term'])) {
  
    // sanitize user input to prevent SQL injection
    $search_term = filter_input(INPUT_GET, 'search-term', FILTER_SANITIZE_STRING);

  //Validating input:
  //so basicallu this stops person from inputting anything numbers or symbols.

    $invalid_input = "/[^a-zA-Z\s]/";
    if (preg_match($invalid_input, $search_term)){
      //error message when you input num/symbols/special characters etc.
      echo "<div style=
              '
              border: 2px solid #000000; 
              background-color: #f0f0f0; 
              padding: 10px; 
              margin: 10px 350;
              text-align: center;
              color: #ff0000 

              '>";
      
      echo " <b> Invalid input </b>";
      echo "</div>";
    
    }
    // srching the table to find like terms to show results
    $query = "SELECT * FROM products WHERE product_name LIKE '%{$search_term}%' OR product_category LIKE '%{$search_term}%'";


    
  } else {
    $query = "SELECT * FROM products";
  }
  



$results = $db->query($query); 
                        foreach($results as $product) {
                        ?>
                            <div class="product-card" id="<?=$product["product_id"]?>"> <?= $product["product_category"] ?> 
                                <div>
                                <img src="product_img/<?= $product["ImageURL"] ?>" style="height: 100%; width: 100%; object-fit: contain";>
                                </div>
                                <div class="product-card-info">
                                <p class="product-card-name"> <?= $product["product_name"] ?> </p>
                                <p class="product-card-gender"> <?= $product["product_gender"] ?> </p>
                                <p class="product-card-price">£<?= $product["product_price"] ?> </p>
                                </div>
                                <button class="add-to-cart-btn" data-product-id="<?= $product["product_id"] ?>">Add to Cart</button>
                            </div>
                        <?php
                        }





// echo "<table>";
// echo "<tr><th>Product Name</th><th>Product Price</th><th>Product Colour</th><th>Product Gender</th><th>Product Category</th></tr>";

// while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//   echo "<tr>";
//   echo "<td>" . $row['product_name'] . "</td>";
//   echo "<td>" . $row['product_price'] . "</td>";
//   echo "<td>" . $row['product_colour'] . "</td>";
//   echo "<td>" . $row['product_gender'] . "</td>";

//   echo "<td>" . $row['product_category'] . "</td>";

//   echo "</tr>";
// }
// echo "</table>";




?>
