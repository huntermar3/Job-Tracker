<?php
session_start();

// db connection
require_once "../config/database.php";

// check if logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

$username = $_SESSION['username'];

// get user id
$sql = $conn->prepare("SELECT UserID FROM USERS WHERE Username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($row = $result->fetch_assoc()) {
    $user_id = $row['UserID'];
} else {
    die("User not found.");
}
$sql->close();

// check spreadsheet id
if (!isset($_POST['sheet_id'])) {
    die("No spreadsheet ID found.");
}

$sheet_id = $_POST['sheet_id'];

// verify ownership + get spreadsheet title
$sql = $conn->prepare("SELECT Title FROM SPREADSHEET WHERE id = ? AND user_id = ?");
$sql->bind_param("ii", $sheet_id, $user_id);
$sql->execute();
$result = $sql->get_result();

if ($row = $result->fetch_assoc()) {
    $sheet_title = $row['Title'];
} else {
    die("Spreadsheet not found or access denied.");
}
$sql->close();

// fetch all jobs for this spreadsheet
$sql = $conn->prepare("
    SELECT JobID, CName, JTitle, Location, Salary, C_Email, C_Phone, Job_Desc, Date_App, App_Status
    FROM JOB_LISTING
    WHERE Spreadsheet_id = ?
    ORDER BY Date_App DESC
");
$sql->bind_param("i", $sheet_id);
$sql->execute();
$result = $sql->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}
$sql->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Tracker</title>
  <link rel="stylesheet" href="../css/opening_spreadsheet.css">
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

    <div class="title-and-back-container">
        <a href="../views/dashboard.php" class="back-button">Back to Dashboard</a>
        <h2 class="title-of-sheet"><?php echo htmlspecialchars($sheet_title); ?></h2>
    </div>

    <button id="openModal" class="add-job-button">+ Add Job</button>

    <div id = "modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="../controllers/create_job.php">
                <input type="hidden" name="sheet_id" value="<?php echo $sheet_id; ?>">
                
                <div class = "modal-row">
                <label for="CName">Company:</label>
                <input type="text" name="CName" maxLength = "50" required><br>
                </div>
                
                <div class = "modal-row">
                <label for="JTitle">Job Title:</label>
                <input type="text" name="JTitle"  maxLength = "50" required><br>
                </div>
                
                <div class = "modal-row">
                <label for="Location">Location:</label>
                <input type="text" name="Location" maxLength = "50" required><br>
                </div>
                
                <div class = "modal-row">
                <label for="Salary">Salary:</label>
                <input type="number" name="Salary" maxLength = "50"><br>
                </div>
                
                <div class = "modal-row">
                <label for="C_Email">Contact Email:</label>
                <input type="email" name="C_Email" maxLength = "50"><br>
                </div>
                
                <div class = "modal-row">
                <label for="C_Phone">Contact Phone:</label>
                <input type="text" name="C_Phone" maxLength = "50"><br>
                </div>
                
                <!-- <div class = "modal-row">
                <label for="Job_Desc">Job Description:</label>
                <textarea name="Job_Desc"></textarea><br>
                </div> -->
                
                <div class = "modal-row">
                <label for="Date_App">Date Applied:</label>
                <input type="date" name="Date_App" maxLength = "50" required><br>
                </div>
                
                <div class = "modal-row">
                <label for="App_Status">Application Status:</label>
                <input type="text" name="App_Status" maxLength = "50"><br>
                </div>
                
                <button class="create-job-button" type="submit">Add Job</button>
            </form>
        </div>
    </div>

    <div class="jobs-container">
        <?php if (empty($jobs)): ?>
            <p class = "no-jobs-text">No jobs added to this spreadsheet yet!</p>
        <?php else: ?>
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Salary</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($job['JTitle']); ?></td>
                            <td><?php echo htmlspecialchars($job['CName']); ?></td>
                            <td><?php echo htmlspecialchars($job['Location']); ?></td>
                            <td>$<?php echo number_format($job['Salary']); ?></td>
                            <td><?php echo htmlspecialchars($job['C_Email']); ?></td>
                            <td><?php echo htmlspecialchars($job['C_Phone']); ?></td>
                            <td><?php echo htmlspecialchars($job['Date_App']); ?></td>
                            <td><?php echo htmlspecialchars($job['App_Status']); ?></td>
                            <td>
                                <form method="post" action="../controllers/delete_job.php">
                                    <input type="hidden" name="job_id" value="<?php echo $job['JobID']; ?>">
                                    <input type="hidden" name="sheet_id" value="<?php echo $sheet_id; ?>">
                                    <button type="submit">Delete</button>
                                </form>
                                <form method="post" action="../controllers/edit_job.php">
                                    <input type="hidden" name="job_id" value="<?php echo $job['JobID']; ?>">
                                    <input type="hidden" name="sheet_id" value="<?php echo $sheet_id; ?>">
                                    <button type="submit">Edit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
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
