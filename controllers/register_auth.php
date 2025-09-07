<?php
require_once "../config/database.php";

//we sent a post req to this file, we can grab the username and password the user jsut entered
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // if any of them are blank, tell them it cant be blank and reset
    if (!$username || !$password || !$confirmPassword) {
        echo "<script>
                alert('All fields are required.');
                window.location.href = '../views/register.php';
              </script>";
        exit();
    }

    // make sure the passwords match
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match. Please try again.');
                window.location.href = '../views/register.php';
              </script>";
        exit();
    }

    // check if username already exists
    $checkSql = "SELECT UserID FROM USERS WHERE Username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>
                alert('Username already exists. Please choose another.');
                window.location.href = '../views/register.php';
              </script>";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    $checkStmt->close();

    // insert new user
    $sql = "INSERT INTO USERS (Username, Password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please sign in with your new account.');
                window.location.href = '../views/login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = '../views/register.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
