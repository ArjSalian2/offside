<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database
require_once('connection.php');

// Retrieve user ID from the session
$userID = $_SESSION['user_id'];

// Retrieve data sent from the client-side
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

// Validate current password (you may want to enhance this validation)
$stmtCheckPassword = $db->prepare("SELECT pass FROM users WHERE UserID = ?");
$stmtCheckPassword->execute([$userID]);
$hashedPassword = $stmtCheckPassword->fetchColumn();

if (!password_verify($currentPassword, $hashedPassword)) {
    $_SESSION['password_error'] = "Current password is incorrect.";
    header('Location: user_details.php');
    exit();
}

// Check if new password matches the confirmed password
if ($newPassword !== $confirmPassword) {
    $_SESSION['password_error'] = "New password and confirm password do not match.";
    header('Location: user_details.php');
    exit();
}

// Update the password in the database
$stmtUpdatePassword = $db->prepare("UPDATE users SET pass = ? WHERE UserID = ?");
$stmtUpdatePassword->execute([password_hash($newPassword, PASSWORD_DEFAULT), $userID]);

// Set a success message
$_SESSION['password_success'] = "Password successfully updated.";

// Redirect back to user_details.php
header('Location: user_details.php');
exit();
?>
