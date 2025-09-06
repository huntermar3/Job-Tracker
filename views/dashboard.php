<?php
    session_start();

    //db connection
    require_once "../config/database.php";

    //make sure the user is logged in, _SESSION is an array that stores tokens. When the user logs in this should 'username' should be stored
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Tracker</title>
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<div class="main-container">

    <div class="title-logout-container">
        <h2 class="title">Job Tracker</h2>
        <form method="post" action="../controllers/logout.php">
            <button class="logout-button" type="submit">Log Out</button>
        </form>
    </div>
    <hr>

    <div class="dashboard-container">
        <button id="openModal" class="create-spreadsheet-button">+ Create a new spreadsheet</button>

        <h3 class="spreadsheets-textview">Your Spreadsheets</h3>

        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post" action="create_spreadsheet.php">
                    <label for="sheetName">Spreadsheet Name:</label>
                    <input type="text" class="sheetName" name="sheetName" required>
                    <button class = "create-sheet-button" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    const modal = document.getElementById("modal");
    const openModalBtn = document.getElementById("openModal");
    const closeBtn = document.querySelector(".close");

    // show modal when button is clicked
    openModalBtn.onclick = () => {
        modal.style.display = "flex";
    };

    // hide modal when X is clicked
    closeBtn.onclick = () => {
        modal.style.display = "none";
    };

    // hide modal when clicking outside modal content
    window.onclick = (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };
</script>

</body>
</html>
