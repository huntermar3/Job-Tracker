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
            <button class = "signup-button" href = "views/register.php">Signup</button>
        </div>

        <div class = "username-container"> 
            <h6 class= "username">Username</h6>
            <input type = "text" class = "username-input" placeholder = "Enter your username" required></input>
        </div>

        <div class = "password-container"> 
            <h6 class = "password">Password</h6>
            <input type = "password" class = "password-input" placeholder = "Enter your password" required></input>
        </div>

        <button class = "signin-button">Sign-in </button>
    </div>
</div>
   
</body>

</html>
