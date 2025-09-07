<?php
session_start();
require_once "../config/database.php";

//grab the username and password the user just entered
$username = $_POST["username"] ?? '';
$password = $_POST["password"] ?? '';

//if the username or password is blank tell the user it must not be blank
if (empty($username) || empty($password)) {
    echo "<script>
            alert('Username and password are required.');
            window.location.href = '../views/login.php';
          </script>";
    exit();
}

$stmt = $conn->prepare("SELECT Password FROM USERS WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    //grab the password inside the database
    $dbpassword = $row['Password'];

    // if password user entered is the same as the password stored in the database
    if ($password === $dbpassword) {
        // store the username in the session. A session in PHP is basically a way to remember data about a user across multiple pages
        $_SESSION['username'] = $username;
        echo "<script>
                window.location.href = '../views/dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Incorrect password. Please try again.');
                window.location.href = '../views/login.php';
              </script>";
    }
} 
// if the number of rows is empty, then we know taht we didnt find the username/password
else {
    echo "<script>
            alert('Username not found. Please try again.');
            window.location.href = '../views/login.php';
          </script>";
}

$stmt->close();
$conn->close();
?>
