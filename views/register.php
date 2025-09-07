<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Tracker</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

<div class="main-container">
    <div class="center-container">
        <h3 class="title">Job Tracker</h3>
        <p class="small-text">Manage your job applications efficiently</p>

        <div class="login-signup-container">
            <a href="login.php" class="login-button">Login</a>
            <button class="signup-button">Sign-up</button>
        </div>

        <form action="../controllers/register_auth.php" method="POST">
            <div class="username-container"> 
                <h6 class="username">Username</h6>
                <input 
                    type="text" 
                    class="username-input" 
                    name="username" 
                    placeholder="Enter a username" 
                    required>
            </div>

            <div class="password-container"> 
                <h6 class="password">Password</h6>
                <input 
                    type="password" 
                    class="password-input" 
                    name="password" 
                    placeholder="Enter a password" 
                    required>
            </div>

            <div class="password-container"> 
                <h6 class="password">Confirm Password</h6>
                <input 
                    type="password" 
                    class="password-input" 
                    name="confirm_password" 
                    placeholder="Confirm your password" 
                    required>
            </div>

            <button type="submit" class="signin-button">Sign-up</button>
        </form>
    </div>
</div>
   
</body>
</html>
