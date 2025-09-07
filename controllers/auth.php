<?php
    // Database connection settings
    $host = "localhost";
    $dbname = "job_tracker";  // Database name
    $user = "root";
    $pass = ""; //MySQL password

    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($username) || empty(password)){
        die("Username and password are required");
    }

    // Prepare to fetch dependent on username
    $stmt = $conn->prepare("SELECT Password FROM USERS WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        //$hashedPassword = $row['Password'];
        $dbpassword = $row['Password'];
        // Verify submitted password against the hash
        if (password_verify($password, $dbpassword)) {
            echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
            // In the future code can be added here to call another php file with a dashboard rather than echo a welcome
        }
        else {
            echo "Incorrect password. Please try again.";
        }
    } 
    else {
        echo "Username not found. Please try again";
    }

    $stmt->close();
    $conn->close();
?>