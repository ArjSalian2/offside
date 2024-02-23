<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to the login page if not logged in
    exit();
}

// Connect to the database
require_once('connection.php');

// Retrieve user details from the Users table
$userID = $_SESSION['user_id'];
$stmtUser = $db->prepare("SELECT * FROM users WHERE userID = ?");
$stmtUser->execute([$userID]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

$stmtPayment = $db->prepare("SELECT * FROM payment WHERE userID = ?");
$stmtPayment->execute([$userID]);
$paymentMethods = $stmtPayment->fetchAll(PDO::FETCH_ASSOC);

// Check if the address already exists for the user
$stmtAddress = $db->prepare("SELECT * FROM address WHERE userID = ?");
$stmtAddress->execute([$userID]);

$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'account-details';

// Fetch address details
if ($stmtAddress->rowCount() > 0) {
    $address = $stmtAddress->fetch(PDO::FETCH_ASSOC);
} else {
    $address = array(); // Set $address to an empty array if no address exists
}

// Check for password update messages
$passwordSuccess = isset($_SESSION['password_success']) ? $_SESSION['password_success'] : null;
$passwordError = isset($_SESSION['password_error']) ? $_SESSION['password_error'] : null;

// Clear session variables
unset($_SESSION['password_success']);
unset($_SESSION['password_error']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../homepage-img/logo.png">
    <title>User Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .page-container{
            /**position: relative;**/
            bottom: 250px;
            display: flex;
        }

        header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        }

        .top-right-nav{
        margin-left: auto;
        background-color:rgb(255, 255, 255);
        /* flex-grow: 1; */
        } 

        .logo img { 
        max-width: 100px;
        height: auto;
        /* position: absolute;
        top:0;
        left:0;
        padding:5px; */
        }

        /* Dima- nav,basket,search bar */
        #nav1{
        display:flex;
        align-items: center;
        gap: 10px;
        padding: 11px;
        margin-left: 850px; 
        background-color:white;
        }

        #nav1 a{
        text-decoration: none;
        color: rgb(11,10,10);
        font-size: 13px;
        text-align: center;
        padding:3px 10px;
        /* margin: 0 5px; */
        }
        #nav1 a:hover{
        background-color: transparent;
        color: darkgray;
        }

        #nav2{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        padding: 10px;
        box-sizing:border-box;
        }
        #nav2 a:hover{
        background-color: transparent;
        color: darkgray;
        }
        #nav2 a{
        text-decoration: none;
        color:black;
        text-align: center;
        padding: 5px 15px;
        font-size: 14px;
        }
        .nav2-center{
        flex-grow:1;
        display: flex;
        justify-content: center;
        margin-left: 300px;
        }
        .nav2-right{
        display: flex;
        align-items: center;
        }
        
        #search form{
        display:flex;
        align-items: center;
        border:1px solid #ccc;
        border-radius: 15px;
        overflow: hidden;
        margin-right: 10px;
        }
        #search input[type="text"]{
        border:none;
        padding:8px;
        outline: none;
        font-size: 13px;
        }
        #search input[type="submit"]{
        background-color: white;
        border:none;
        padding:8px 12px;
        font-size: 14px;
        }

        #search input[type="submit"]:hover{
        background-color: #e0e0e0;
        }
        #basket-icon{
        margin-right: 10px;
        }
        #basket-icon a img{
        width: 20px;
        height: auto;
        }
        
        .messages-container {
            position: absolute;
            right: 0;
            margin-top: 10px;
        }

        .error-message, .success-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .detail {
            margin-bottom: 15px;
        }

        .edit-input {
            border: 1px solid #000;
            border-radius: 4px;
            padding: 10px;
            width: 100%;
            margin-bottom: 30px;
        }

        .save-button {
            background-color: #fff; /* White button */
            color: #000; /* Black text */
            border: 1px solid #000; /* Black border for button */
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 2; 
        }

        .form-container {
            width: 100%;
        }

        .settings-header{
            margin-bottom: 50px;
        }

        .tabs {
            position: absolute;
            left: 5%;
            margin-bottom: 20px;
            flex-direction: column;
            padding: 20px;
        }

        .tab {
            cursor: pointer;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .tab-content {
            padding: 20px;
            max-width: 400px;
            width: 100%;
            margin: auto;
            /**margin-top: 50vh;**/
            margin-top: 26px;
        }

        .password-container{
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-value{
            margin-right: 10px;
        }

        .edit-button{
            margin-left: 10px; 
            font-size: smaller;
            cursor: pointer;
            background: transparent;
            text-decoration: 2px underline;
            border: 0px;
        }

        .paymentForm {
            display: flex;
            flex-direction: column;
        }

        .payment-method {
            margin-bottom: 10px;
        }

        .add-payment-button {
            margin-top: 10px;
            cursor: pointer;
            color: blue;
        }

        .payment-method {
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .payment-container{
            justify-content: center;
            align-items: baseline; 
            display: flex;
            width: 300px;
        }

        .payment-details {
            flex-grow: 1;
        }

        .detail {
            margin-bottom: 0;
        }

        .delete-button {
            margin-left: 10px; 
        }

        .logout{
            background-color: #fff; /* White button */
            color: #000; /* Black text */
            border: 1px solid #000; /* Black border for button */
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 50px;
        }

    </style>
    <link rel="stylesheet" href="../nav-styles.css" />
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
    
        <div class="logo"> <!--Hadeeqa-The logo for top of page-->
            <a href="/offside/index.html">
                <img src="../homepage-img/logo.png" alt="Offside Logo">
            </a>
        </div>
    
        <div class="top-right-nav">
            <div id="nav1">
                <a href="../about.html">About Us</a>
                <a href="../basket/contact.php">Contact Us</a>
                <a href="login.php">Log In</a>
                <a href="user_details.php">Account details</a>
                <a href="../basket/my_orders.php">My orders</a>
            </div>
        </div>
    
    </header>
    
    <div id="nav2">
        <div class="nav2-center">
            <a href="../products.php?gender%5B%5D=womens">Women</a>
            <a href="../products.php?gender%5B%5D=mens">Men</a>
            <a href="../products.php?category%5B%5D=accessories">Accessories</a>
        </div>
    
        <div class="nav2-right">
            <div id="search">
                <form>
                    <input type="text" name="search" placeholder="Search">
                    <input type="submit" value="Enter">
                </form>
            </div>
            <div id="basket-icon">
                <a href="../basket/cart.php"><img src="../homepage-img/basket-icon.png" alt="Basket"></a>
            </div>
        </div>
    </div>

    <div id="banner">
        <h2> Free Delivery & Returns</h2>
        <p> Offside members get free delivery and 60-day returns</p>
      </div>
      
    <div class="messages-container">
        <?php if ($passwordError): ?>
        <div class="error-message"><?php echo $passwordError; ?></div>
            <?php elseif ($passwordSuccess): ?>
        <div class="success-message"><?php echo $passwordSuccess; ?></div>
        <?php endif; ?>
    </div>

    <div class="messages-container">
        <?php if ($passwordError): ?>
        <div class="error-message"><?php echo $passwordError; ?></div>
        <?php elseif ($passwordSuccess): ?>
        <div class="success-message"><?php echo $passwordSuccess; ?></div>
        <?php endif; ?>
    </div>
        
    <div class="messages-container">
        <?php
        if (isset($_SESSION['errorMessage']) && !empty($_SESSION['errorMessage'])) {
            echo "<p class='error-message' style='color: red;'>" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']); // Clear the error message after displaying it
        }
        ?>
    </div>

    <div class="page-container">
        <div class="tabs">
            <h1 class="settings-header">Settings</h1>
            <div class="tab" onclick="showTab('account-details')">Account Details</div>
            <div class="tab" onclick="showTab('paymentForm')">Payment Methods</div>
            <button class="logout" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    
    
    
        <div class="tab-content" id="account-details">
            <form method='post' action='update_details.php'>
                <div class="details-container">
                    <h2>User Details</h2> 
    
                    <!-- Display user details from the Users table --> 
                    <div class="detail">
                        <label>Email: </label>
                        <input type="email" class="edit-input" name="email" value="<?php echo $user['Email']; ?>">
                    </div>
                    <div class="detail">
                        <label>Password: </label>
                        <div class="password-container">
                            <span class="password-value">******</span>
                            <button type="button" class="edit-button" onclick="openPasswordForm()">Edit</button>
                            
                        </div>
                    </div>
                    <br>
                    <label>First Name: </label>
                    <input type="text" class="edit-input" name="firstName" value="<?php echo $user['First Name']; ?>">
                    <br>
                    <label>Last Name: </label>
                    <input type="text" class="edit-input" name="lastName" value="<?php echo $user['Last Name']; ?>">
                    <br>
                    <label>Phone: </label>
                    <input type="tel" pattern="[0-9]{5} [0-9]{6}" placeholder="00000 000000" class="edit-input" name="phone" value="<?php echo $user['Phone Number']; ?>">
                    <br>
                    <label>Address</label>
                    <input type="text" class="edit-input" name="addressLine" value="<?php if(isset($address['AddressLine'])){ echo $address['AddressLine'] ;} else{echo '';}?>">
                    <br>
                    <label>City</label>
                    <input type="text" class="edit-input" name="city" value="<?php if(isset($address['City'])){ echo $address['City'] ;} else{echo '';}?>">
                    <br>
                    <label>Region</label>
                    <input type="text" class="edit-input" name="region" value="<?php if(isset($address['Region'])){ echo $address['Region'] ;} else{echo '';}?>">
                    <br>
                    <label>Postcode</label>
                    <input type="text" class="edit-input" name="postcode" value="<?php if(isset($address['Postcode'])){ echo $address['Postcode'] ;} else{echo '';}?>">
                    <br>
                    <label>Country</label>
                    <input type="text" class="edit-input" name="country" value="<?php if(isset($address['Country'])){ echo $address['Country'] ;} else{echo '';}?>">
                    <br>
    
                    <!-- Save Changes button -->
                    <button class="save-button">Save Changes</button>
                    <input type="hidden" name="submitted" value="TRUE" />
                </div>
            </form>
    
                <script>
                    // Clear password input fields and display the passwordForm popup
                    document.getElementById("currentPassword").value = "";
                    document.getElementById("newPassword").value = "";
                    document.getElementById("confirmPassword").value = "";
                    document.getElementById("passwordForm").style.display = "block";
                </script>
    
    
            <div class="form-popup" id="passwordForm">
            <form id="updatePasswordForm" method="post" action="update_password.php" class="form-container">
                <h1>Update Password</h1>
    
                <div>
                    <label for="currentPassword"><b>Current Password</b></label>
                    <input id="currentPassword" type="password" placeholder="Enter Current Password" name="currentPassword" required>
                </div>
                <br>
                <div>
                    <label for="newPassword"><b>New Password</b></label>
                    <input id="newPassword" type="password" placeholder="Enter New Password" name="newPassword" minlength="8" required>
                </div>
                <br>
                <div>
                    <label for="confirmPassword"><b>Confirm Password</b></label>
                    <input id="confirmPassword" type="password" placeholder="Confirm New Password" name="confirmPassword" minlength="8" required>
                </div>
                <br>
                <button type="submit" class="btn">Save Changes</button>
                <button type="button" class="btn cancel" onclick="closePasswordForm()">Close</button>
            </form>
            </div>
        </div>
    
    
    
    
        <div class="tab-content" id="paymentForm">
            <?php if ($paymentMethods === null || empty($paymentMethods)): ?>
                <p>No payment methods added.</p>
            <?php else: ?>
                <?php foreach ($paymentMethods as $paymentMethod): ?>
                    <div class="payment-method">
                        <label>Card Number:</label>
                        <div class="payment-container">
                            <div class="edit-input">Card ending 
                             <?php echo substr($paymentMethod['AccountNumber'], -4); ?>
                            <br>
                            Expires: <?php echo substr($paymentMethod['ExpiryDate'], -4); ?></div>
                            <form method="post" action="update_payment.php">
                                <input type="hidden" name="PaymentID" value="<?php echo $paymentMethod['PaymentID']; ?>">
                                <button type="submit" name="delete-payment" class="delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
    
            <div class="add-payment-button" onclick="openPaymentForm()">Add Payment Method</div>
        </div>
    
        <div class="form-popup" id="paymentPopup">
        <form method="post" action="update_payment.php" class="form-container">
            <h1>Add Payment Method</h1>
    
            <div>
                <label for="accountNumber"><b>Card Number</b></label>
                <input id="accountNumber" type="text" placeholder="Card Number" name="accountNumber" required>
            </div>
            <br>
            <div>
                <label for="expirationDate"><b>ExpirationDate</b></label>
                <input id="expirationDate" type="text" placeholder="MM/YY" name="expirationDate" required>
            </div>
            <br>
            <div>
                <label for="cvv"><b>CVV</b></label>
                <input id="cvv" type="text" placeholder="CVV" name="cvv" required>
            </div>
            <br>
            <button type="submit" class="btn">Add Payment Method</button>
            <input type="hidden" name="submitted" value="TRUE" />
            <button type="button" class="btn cancel" onclick="closePaymentForm()">Close</button>
        </form>
    </div>
</div>

    <script>
        function openPasswordForm() {
            document.getElementById("passwordForm").style.display = "block";
        }

        function closePasswordForm() {
            document.getElementById("passwordForm").style.display = "none";
        }

        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.style.display = 'none';
            });

            document.getElementById(tabName).style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            showTab('<?php echo $selectedTab; ?>');
        });

        function closePaymentForm() {
            document.getElementById("paymentPopup").style.display = "none";
        }

        function openPaymentForm() {
            document.getElementById("paymentPopup").style.display = "block";
        }
    </script>

</body>
</html>
