<?php
session_start();
require_once "../config/database.php";

// make sure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['sheet_id'])) {
    $sheet_id = $_POST['sheet_id']; 

    // check that the spreadsheet belongs to this user:
    $username = $_SESSION['username'];
    $sql = $conn->prepare("SELECT UserID FROM users WHERE Username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['UserID'];

        // delete only if this sheet belongs to this user
        $delete = $conn->prepare("DELETE FROM SPREADSHEET WHERE id = ? AND user_id = ?");
        $delete->bind_param("ii", $sheet_id, $user_id);
        $delete->execute();

        $delete->close();
    }

    $sql->close();
}

// redirect back to dashboard
header("Location: ../views/dashboard.php");
exit();
?>
