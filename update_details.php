<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle the case where the user is not logged in
    exit('User is not logged in');
}

// Connect to the database (adjust your database connection details)
require_once('connection.php');

// Retrieve user ID from the session
$userID = $_SESSION['user_id'];

// Retrieve user details from the Users table
$stmtUser = $db->prepare("SELECT * FROM users WHERE userID = ?");
$stmtUser->execute([$userID]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize data if needed
    $data = $_POST;

    // Update password only if it's provided and not null
    if (isset($data['password']) && $data['password'] !== null) {
        $stmtUser = $db->prepare("UPDATE users SET password = ? WHERE UserID = ?");
        $stmtUser->execute([$data['password'], $userID]);
    }

    // Update user details in the users table
    $stmtUser = $db->prepare("UPDATE users SET `Email` = ?, `First Name` = ?, `Last Name` = ?, `Phone Number` = ? WHERE `UserID` = ?");
    $stmtUser->execute([$data['email'], $data['firstName'], $data['lastName'], $data['phone'], $userID]);

    // Check if the user already has an address
    $stmtAddressCheck = $db->prepare("SELECT * FROM address WHERE userID = ?");
    $stmtAddressCheck->execute([$userID]);
    $addressExists = $stmtAddressCheck->fetch(PDO::FETCH_ASSOC);


    // Update or insert address details in the address table
    if ($addressExists) {
        $stmtAddressUpdate = $db->prepare("UPDATE address SET `AddressLine` = ?, `City` = ?, `Region` = ?, `Postcode` = ?, `Country` = ? WHERE `AddressID` = ?");
        $stmtAddressUpdate->execute([$data['addressLine'], $data['city'], $data['region'], $data['postcode'], $data['country'], $addressExists['AddressID']]);
    } else {
        $stmtAddressInsert = $db->prepare("INSERT INTO address (UserID, AddressLine, City, Region, Postcode, Country) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtAddressInsert->execute([$userID, $data['addressLine'], $data['city'], $data['region'], $data['postcode'], $data['country']]);
    }

    // Redirect back to the user_details.php page
    header('Location: user_details.php?tab=account-details');
    exit();
}
?>
