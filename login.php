<?php
session_start();

// If the form has been submitted
if (isset($_POST['submitted'])) {
    // Check if both email and password are set
    if (!isset($_POST['email'], $_POST['password'])) {
        exit('Please fill both the email and password fields!');
    }

    // Connect to the database
    require_once("connection.php");

    try {
        // Query the database to find the matching email
        $stmt = $db->prepare('SELECT userID, Email, Pass FROM users WHERE Email = ?');
        $stmt->execute([$_POST['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the email exists
        if ($stmt->rowCount() > 0) {
            // Check if the provided password matches the stored hash
            if (password_verify($_POST['password'], $user['Pass'])) {
                // Start the session and the store user information
                session_start();
                $_SESSION["user_id"] = $user['userID'];
                $_SESSION["email"] = $_POST['email'];

                // Redirect to the user details page
                header("Location: user_details.php");
                exit();
            } else {
                echo "<p style='color:red'>Error logging in, password does not match</p>";
            }
        } else {
            echo "<p style='color:red'>Error logging in, email not found</p>";
        }
    } catch (PDOException $ex) {
        echo("Failed to connect to the database.<br>");
        echo($ex->getMessage());
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff; /* White background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
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

        .submit-button {
            background-color: #fff; /* White button */
            color: #000; /* Black text */
            border: 1px solid #000; /* Black border for button */
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .link {
            text-decoration: none;
            color: #000; /* Black link color */
            display: block;
            text-align: center;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form method="post" action="login.php" class="login-container">
        <h2>Login</h2>
        <br>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" class="form-input" required>
        </div>
        <br>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-input" required>
        </div>
        <br>
        <button type="submit" name="submitted" class="submit-button">Login</button>

        <div>
            <a href="signup.php" class="link">Don't have an account? Sign up here</a>
        </div>
    </form>
</body>
</html>
