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

    // find the user id so we can reference that id in all the spreadsheets
    $sql = $conn->prepare(
    "SELECT UserID 
    FROM users 
    WHERE Username = ?"
    );
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['UserID'];
    } else {
        die("User not found.");
    }

    $sql->close();

    //fetch the user's spreadsheets. I want to display the recently modified on top.
    $sql = $conn->prepare("
    SELECT id, Title, Modified_At, Date_Created
    FROM SPREADSHEET
    WHERE user_id = ?
    ORDER BY Modified_At DESC
    ");
    $sql->bind_param("i", $user_id);
    $sql->execute();
    $result = $sql->get_result();

    //store spreadsheets in an array
    $spreadsheets = [];
    while ($row = $result->fetch_assoc()) {
        $spreadsheets[] = $row;
    }

    $sql->close();

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
                <form method="post" action="../controllers/create_spreadsheet.php">
                    <label for="sheetName">Spreadsheet Name:</label>
                    <input type="text" class="sheetName" name="sheetName" required>
                    <button class = "create-sheet-button" type="submit">Create</button>
                </form>
            </div>
        </div>

        <?php
            echo "<div class = 'spreadsheets-container'> " ;
            if(empty($spreadsheets)){
                echo "<h4 class = 'empty-spreadsheets-text'>There are no spreadsheets yet! </h4>" ;
            } 
            // if the variable  (its and array) spreadsheet is populated then we can say the user must have spreadsheets
            else {
                foreach ($spreadsheets as $sheet){
                    echo "<div class = 'individual-spreadsheet'> " ;
                    echo "<div class = 'top-row-of-spreadsheet'>";
                    echo "<h3 class = 'title-of-spreadsheet'> " . $sheet["Title"] . "</h3>";
                    echo "<form method='post' action='../controllers/delete_spreadsheet.php'>";
                    echo "<input type='hidden' name='sheet_id' value='" . $sheet["id"] . "'>";
                    echo "<button class='delete-button' type='submit'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "<p class = 'last-modified-text'>Last Modified:". $sheet["Modified_At"] . "</p>";
                    echo "<button class = 'open-spreadsheet-button'> Open Spreadsheet </button>";
                    echo "</div>";
                }
            }

            echo "</div>";
        ?>
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
