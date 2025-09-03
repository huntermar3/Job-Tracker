<?php
// Start a session (needed for login systems later)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Tracker</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <h1>Welcome to Job Tracker</h1>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Hello, <?php echo $_SESSION['user']; ?>! You are logged in.</p>
        <a href="views/dashboard.php">Go to Dashboard</a> |
        <a href="controllers/auth.php?logout=true">Logout</a>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="views/login.php">Login</a> |
        <a href="views/register.php">Register</a>
    <?php endif; ?>

</body>
</html>
