<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Register</h2>
        <form action="#" method="POST" class="register-form">
            
            <div class="form-group">
                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required>
            </div>
            
            <div class="form-group">
                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Registruj se</button>
            
        </form>
    </div>
    </div>
</body>

</html>