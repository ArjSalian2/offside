<?php
session_start();

// If the form has been submitted
if (isset($_POST['submitted'])) {

    error_log("Form Data: " . print_r($_POST, true));

    require_once('connection.php');

    $email = isset($_POST['email']) ? $_POST['email'] : false; // Adjusted case
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false; // Adjusted case
    $userType = '1';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : false; // Adjusted case
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : false; // Adjusted case
    $phone = isset($_POST['phone']) ? $_POST['phone'] : false; // Adjusted case

    // Check if the email is already in use
    $stmtCheckEmail = $db->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
    $stmtCheckEmail->execute([$email]);
    $emailCount = $stmtCheckEmail->fetchColumn();

    if ($emailCount > 0) {
        $_SESSION['errorMessage'] = "Email already exists";
        header('Location: signup.php');
        exit();
    }
    
    error_log("User Insert Query: " . "INSERT INTO users ('Email', 'Pass', 'user-type') VALUES ('$email', '$password', '$userType')");

    if (!$email || !$password || !$firstName || !$lastName || !$phone ) {
        exit("One or more form fields are invalid or missing.");
    }

    try {
        // Register the user by inserting the user info into the Users table
        $stmtUser = $db->prepare("INSERT INTO users (`First Name`, `Last Name`, `Email`, `Pass`, `Phone Number`, `user_type`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtUser->execute([$firstName, $lastName, $email, $password, $phone, $userType]);

        // Get the last inserted UserID
        $userID = $db->lastInsertId();

        header('Location: login.php');
    } catch (PDOException $ex) {
        echo "Sorry, a database error occurred! <br>";
        echo "Error details: <em>" . $ex->getMessage() . "</em>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
        
        .signup-container {
            padding: 20px;
            max-width: 400px;
            width: 100%;
            margin: auto;
        }
        
        .form-input {
            border: 1px solid #000; /* Black outline */
            border-radius: 4px;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        
        button {
            background-color: #fff; /* White button */
            color: #000; /* Black text */
            padding: 10px;
            border: 1px solid #000; /* Black border for button */
            border-radius: 4px;
            cursor: pointer;
        }

        .error-container{
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: inline-block;
        }
    </style>
    
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <div class="error-container">
            <?php
            if (isset($_SESSION['errorMessage']) && !empty($_SESSION['errorMessage'])) {
                echo "<p style='color: red;'>" . $_SESSION['errorMessage'] . "</p>";
                unset($_SESSION['errorMessage']); // Clear the error message after displaying it
            }
            ?>
        </div>
        <form action="signup.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-input" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" minlength="8" class="form-input" required>
            <br>
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" class="form-input" required>
            <br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" class="form-input" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="tel" name="phone" pattern="[0-9]{5} [0-9]{6}" placeholder="00000 000000" class="form-input" required>
            <br>
            <button type="submit">Sign up</button>
            <input type="hidden" name="submitted" value="TRUE" />
        </form>
    </div>
</body>
</html>
