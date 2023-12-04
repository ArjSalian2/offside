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
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .details-container {
            padding: 20px;
            max-width: 400px;
            width: 100%;
            margin: auto;
            margin-top: 50vh;
        }

        .messages-container {
            position: absolute;
            top: 0;
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
            display: none;
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
</head>
<body>
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
                    <input type="text" class="edit-input" name="email" value="<?php echo $user['Email']; ?>">
                </div>
                <div class="detail">
                    <label>Password: </label>
                    <div class="password-container">
                        <span class="password-value">******</span>
                        <button type="button" class="edit-button" onclick="openPasswordForm()">Edit</button>
                        <div class="messages-container">
                            <?php if ($passwordError): ?>
                                <div class="error-message"><?php echo $passwordError; ?></div>
                            <?php elseif ($passwordSuccess): ?>
                                <div class="success-message"><?php echo $passwordSuccess; ?></div>
                            <?php endif; ?>
                        </div>
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
                <input type="text" class="edit-input" name="phone" value="<?php echo $user['Phone Number']; ?>">
                <br>
                <label>Address</label>
                <input type="text" class="edit-input" name="addressLine" value="<?php echo $address['AddressLine'] ?>">
                <br>
                <label>City</label>
                <input type="text" class="edit-input" name="city" value="<?php echo $address['City'] ?>">
                <br>
                <label>Region</label>
                <input type="text" class="edit-input" name="region" value="<?php echo $address['Region'] ?>">
                <br>
                <label>Postcode</label>
                <input type="text" class="edit-input" name="postcode" value="<?php echo $address['Postcode'] ?>">
                <br>
                <label>Country</label>
                <input type="text" class="edit-input" name="country" value="<?php echo $address['Country'] ?>">
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
                <input type="password" placeholder="Enter Current Password" name="currentPassword" required>
            </div>
            <br>
            <div>
                <label for="newPassword"><b>New Password</b></label>
                <input type="password" placeholder="Enter New Password" name="newPassword" required>
            </div>
            <br>
            <div>
                <label for="confirmPassword"><b>Confirm Password</b></label>
                <input type="password" placeholder="Confirm New Password" name="confirmPassword" required>
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
            <input type="text" placeholder="Card Number" name="accountNumber" required>
        </div>
        <br>
        <div>
            <label for="expirationDate"><b>ExpirationDate</b></label>
            <input type="text" placeholder="MM/YY" name="expirationDate" required>
        </div>
        <br>
        <div>
            <label for="cvv"><b>CVV</b></label>
            <input type="text" placeholder="CVV" name="cvv" required>
        </div>
        <br>
        <button type="submit" class="btn">Add Payment Method</button>
        <input type="hidden" name="submitted" value="TRUE" />
        <button type="button" class="btn cancel" onclick="closePaymentForm()">Close</button>
    </form>
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
