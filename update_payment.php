<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to the login page if not logged in
    exit();
}

// Include the database connection file
require_once('connection.php');

// Retrieve user ID from the session
$userID = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitted'])) {
    // Handle payment insertion
    $accountNumber = filter_input(INPUT_POST, 'accountNumber', FILTER_SANITIZE_STRING);
    $expirationDate = filter_input(INPUT_POST, 'expirationDate', FILTER_SANITIZE_STRING);
    $cvv = filter_input(INPUT_POST, 'cvv', FILTER_SANITIZE_STRING);

    // Perform validation on input data if necessary

    // Insert the payment details
    $stmt = $db->prepare("INSERT INTO payment (UserID, AccountNumber, ExpiryDate, CVV) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userID, $accountNumber, $expirationDate, $cvv]);
        
    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        // Redirect to the user details page after adding the payment
        header('Location: user_details.php?tab=paymentForm');
        exit();
    } else {
        // Handle insertion failure (e.g., display an error message)
        echo "Failed to add payment.";
        exit();
    }
}
// Check if the delete button is pressed
if (isset($_POST['delete-payment'])) {
    // Handle payment deletion
    $paymentID = filter_input(INPUT_POST, 'PaymentID', FILTER_SANITIZE_NUMBER_INT);

    // Perform validation on $paymentID if necessary

    $stmt = $db->prepare("DELETE FROM payment WHERE PaymentID = ? AND UserID = ?");
    $stmt->execute([$paymentID, $userID]);
    
    // Check if the deletion was successful
    if ($stmt->rowCount() > 0) {
        // Redirect to the user details page after deleting the payment
        header('Location: user_details.php');
        exit();
    } else {
        // Handle deletion failure (e.g., display an error message)
        echo "Failed to delete payment.";
        exit();
    }
} else {
    // Redirect to the user details page if the form is not submitted
    header('Location: user_details.php');
    exit();
}
?>
