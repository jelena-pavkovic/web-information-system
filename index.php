<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>
 
<body>
    <div class="login-container">
        <h2>Log In</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // Clear the message after displaying
        }
        ?>
        <form action="model/check_user.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Log In</button>
            
        </form>
        
        <p class="register-link">
            No Account? <a href="./view/register.php">Register here!</a>
        </p>
    </div>
</body>

</html>