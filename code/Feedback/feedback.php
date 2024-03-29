<?php
// Start the session
session_start();

// Connect to the database
require_once('../user_files/connection.php');

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../homepage-img/logo.png">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="../nav-styles.css">
    <title>Feedback</title>
</head>

<body>

    <script>
        searchParam = window.location.search;
        url = '../search.php' + searchParam;
        if (searchParam) {
            window.location.href = url;
        }


    </script>

<header>

<div class="logo"> <!--Hadeeqah -The logo for top of page-->
    <a href="/offside/index.php">
        <img src="../homepage-img/logo.png" alt="Offside Logo">
    </a>
</div>

<div class="top-right-nav"> <!-- Hadeeqah- Updated the nav bar -->
    <div id="nav1">

        <?php if ($isAdmin): ?>
        <a href="../Admin Inventory/dashboard.php">Admin</a>
        <?php endif; ?>

        <a href="../about.php">About Us</a>
        <a href="../basket/contact.php">Contact Us</a>
        <a href="../user_files/login.php">Log In</a>
        <a href="../user_files/user_details.php">Account details</a>
        <a href="../view_orders.php">My orders</a>

    </div>
</div>


</header>
<hr>

<!-- nav2-dima -->
<div id="nav2">
<div class="nav2-center">
    <a href="../products.php?gender%5B%5D=womens">Women</a>
    <a href="../products.php?gender%5B%5D=mens">Men</a>
    <a href="../products.php?category%5B%5D=accessories">Accessories</a>
</div>

<div class="nav2-right">
    <div id="search">
        <form>
            <input type="text" name="search-term" placeholder="Search">
            <input type="submit" value="Enter">
        </form>
    </div>
    <div id="basket-icon">
        <a href="../new_cart.php"><img src="../homepage-img/basket-icon.png" alt="Basket"></a>
    </div>
</div>
</div> 


    <section class="main-container">
        <div class="container">
            <div class="wrapper">
                <p class="text"> How is your experience with the website?</p>
                <ul class="emoji-selector">
                    <li>
                        <input type="radio" id="emoji1" name="rating" value="😠">
                        <label for="emoji1"><span>😠</span></label>
                    </li>
                    <li>
                        <input type="radio" id="emoji2" name="rating" value="☹️">
                        <label for="emoji2"><span>☹️</span></label>
                    </li>
                    <li>
                        <input type="radio" id="emoji3" name="rating" value="😑">
                        <label for="emoji3"><span>😑</span></label>
                    </li>
                    <li>
                        <input type="radio" id="emoji4" name="rating" value="🙂">
                        <label for="emoji4"><span>🙂</span></label>
                    </li>
                    <li>
                        <input type="radio" id="emoji5" name="rating" value="😄">
                        <label for="emoji5"><span>😄</span></label>
                    </li>
                    <li>
                        <input type="radio" id="emoji6" name="rating" value="😍">
                        <label for="emoji6"><span>😍</span></label>
                    </li>
                </ul>
            </div>
            <form>
                <input class="Sinput" type="text" name="name" maxlength="100" required placeholder=" Name">
                <input class="Sinput" type="text" name="email" maxlength="100" required placeholder=" Email">
                <textarea class="textarea" cols="30" rows="3" placeholder=" Write your feedback here..."></textarea>
                <div class="button-group">
                    <button type="submit" onclick="submitFeedback()" class="button1" id="upload">Send</button>
                    <button href="" type="submit" class="button2" id="upload">Cancel</button>
                </div>
            </form>
        </div>
    </section>



</body>
<script src="script.js"></script>

</html>