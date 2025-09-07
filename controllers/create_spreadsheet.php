<?php
require_once "../config/database.php";
session_start(); // make sure session is started

$spreadsheetName = $_POST['sheetName'];
$username = $_SESSION['username'];

if (empty($spreadsheetName)) {
    echo "<script>
            alert('Please enter a name for the spreadsheet');
            window.location.href = '../views/dashboard.php';
          </script>";
    exit();
}

// get user_id
$stmt = $conn->prepare("SELECT UserID FROM USERS WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userID = $row['UserID'];

// insert new spreadsheet
$dateCreated = date('Y-m-d H:i:s');
$stmt = $conn->prepare("INSERT INTO SPREADSHEET (user_id, Title, Date_Created, Modified_At) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $userID, $spreadsheetName, $dateCreated, $dateCreated);
$stmt->execute();

echo "<script>
        alert('Spreadsheet created successfully!');
        window.location.href = '../views/dashboard.php';
      </script>";
?>
