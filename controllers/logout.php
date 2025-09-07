<?php
session_start();

// clear all session variables
$_SESSION = array();

// destroy the session
session_destroy();

// delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// redirect to login page
header("Location: ../views/login.php");
exit();
?>