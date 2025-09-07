<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Tracker</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

<div class = "main-container">
    <div class = "center-container">
        <h3 class = "title">Job Tracker</h3>
        <p class = "small-text">Manage your job applications efficiently</p>

        <div class = "login-signup-container">
            <button class = "login-button ">Login</button>
            <a href="register.php" class="signup-button">Sign-up</a>
        </div>

            <form action="../controllers/auth.php" method="POST">
            <div class="username-container"> 
                <h6 class="username">Username</h6>
                <input 
                    type="text" 
                    class="username-input" 
                    name="username" 
                    placeholder="Enter your username" 
                    required>
            </div>

            <div class="password-container"> 
                <h6 class="password">Password</h6>
                <input 
                    type="password" 
                    class="password-input" 
                    name="password" 
                    placeholder="Enter your password" 
                    required>
            </div>

            <button type="submit" class="signin-button">Sign-in</button>
        </form>
    </div>
</div>
   
</body>

</html>
