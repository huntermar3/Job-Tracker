<?php
    $DB_HOST="localhost";
    $DB_NAME="job_tracker";
    $DB_USER="root";
    $DB_PASS="";

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Collect username and password, decide whether or not we need this other data.
    $fname = "fname";
    $minit = '1';
    $lname = "lname";
    $username = $_POST["username"];
    $password = $_POST["password"];
    $userid = "userid";

    //Hash password if neccessary, character limit of password column must be increased to do this
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Create sql statement out of acquired information, ? values are populated by bind_param function
    $sql = "INSERT INTO USERS (FName, Minit, Lname, Username, Password, UserID) VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statements for security
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fname, $minit, $lname, $username, $password, $userid);

    if ($stmt->execute()) {
        echo "New user registered successfully!";
    } 
    else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>