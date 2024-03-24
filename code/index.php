<?php
// Start the session
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

<head> <!-- Hadeeqah head section-->
  <meta charset="utf-8">
  <meta name="author" content="Group 31">
  <meta name="description" content="Offside">
  <link rel="icon" href="homepage-img/logo.png">
  <title> Offside </title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <script>
    searchParam = window.location.search;
    url = 'search.php' + searchParam;
    if (searchParam) {
      window.location.href = url;
    }
  </script>

  <header>

    <div class="logo"> <!--Hadeeqah -The logo for top of page-->
      <a href="/offside/index.php">
        <img src="homepage-img/logo.png" alt="Offside Logo">
      </a>
    </div>

    <div class="top-right-nav">  <!-- Hadeeqah- Updated the nav bar -->
      <div id="nav1">

        <?php if ($isAdmin): ?>
          <a href="Admin Inventory/dashboard.php">Admin</a>
        <?php endif; ?>

        <a href="about.html">About Us</a>
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
          <input  type="text" name="search-term" placeholder="Search">
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
  <div class="banner-image">
    <img src="homepage-img/banner.jpeg" alt="banner image">
  </div>

  <!-- best sellers-dima -->
  <br><br><br>
  <main>
    <div class="title3">
      <h3>Best Sellers</h3>
    </div>
    <div class="slider">
      <div class="slides">
        <!-- FIRST THREE SLIDES-Dima -->
        <div class="slide">
          <img src="product_img/black_shoes.webp" alt="Product1">
          <p>OFFSIDE Black Trainers</p>
        </div>
        <div class="slide">
          <img src="product_img/white_cap.webp" alt="Product2">
          <p>OFFSIDE White Cap</p>
        </div>
        <div class="slide">
          <img src="product_img/blue_hoodie.webp" alt="Product3">
          <p>OFFSIDE Blue Hoodie</p>
        </div>
        <!-- SECOND SET OF SLIDES-Dima -->
        <div class="slide">
          <img src="product_img/red_shoes.webp" alt="Product4">
          <p>OFFSIDE Red Shoes</p>
        </div>
        <div class="slide">
          <img src="product_img/mens_black_tshirt.webp" alt="Product5">
          <p>OFFSIDE Black T-shirt (Mens)</p>
        </div>
        <div class="slide">
          <img src="product_img/womens_brown_tshirt.webp" alt="Product6">
          <p>OFFSIDE Brown T-shirt (Womens)</p>
        </div>
      </div>

      <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
      <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>
  </main>
  <script src="slider.js"></script>
  <br><br><br><br>

  <!-- hadeeqah explore products section  -->
  <div class="explore-products">
    <h2>Explore Our Products</h2>
  </div>

  <div class="explore-products-container"> <!-- Hadeeqah explore our products section -->

    <a href="products.php?gender%5B%5D=mens">
      <img src="homepage-img/men.webp" alt="Men's Products">
      <div class="overlay-text1">Men</div>
    </a>

    <a href="products.php?gender%5B%5D=womens">
      <img src="homepage-img/women.jpg" alt="Women's Products">
      <div class="overlay-text2">Women</div>
    </a>

    <a href="products.php?category%5B%5D=accessories">
      <img src="homepage-img/accessories.webp" alt="Accessories">
      <div class="overlay-text3">Accessories</div>
    </a>
  </div>

  <br>
<!-- new in section- Dima -->
<div class="new-in-section">
  <h3>New In</h3>
  <div class="new-in-slider">
    <div class="new-in-slide">
      <img src="product_img/black_hoodie.webp" alt="New Product 1">
      <p>Black womens hoodie £10</p>
    </div>
    <div class="new-in-slide">
      <img src="product_img/womens_brown_tshirt.webp" alt="New Product 2">
      <p>OFFSIDE Brown T-shirt £10</p>
    </div>
    <div class="new-in-slide">
      <img src="product_img/mens_black_tshirt.webp" alt="New Product 3">
      <p>Black mens t-shirt £10</p>
    </div>
    <div class="new-in-slide">
      <img src="product_img/womens_white_trousers.webp" alt="New Product 4">
      <p>White womens trousers £10</p>
    </div>
  </div>
</div>
  <br><br><br> 
  <footer class="footer">
    <div class="footer-links">
    <a href="user_files/user_details.php">Account Details</a>
      <a href="basket/contact.php">Contact Us</a>
      <a href="FAQ.html">FAQ</a>
      <a href="Returns/allOrders.php">Returns Page</a>
      <a href="Feedback/feedback.php">Feedback Form</a>
      <a href="student.html">Student Discounts</a>
    </div>
    <div class="icons">
      <a href="https://twitter.com/?lang=en" class="fa fa-twitter"></a>
      <a href="https://www.instagram.com/" class="fa fa-instagram"></a>
      <a href="https://www.facebook.com/" class="fa fa-facebook"></a>
  <br><br>
  </div>
  
  </footer>
</body>
</html>