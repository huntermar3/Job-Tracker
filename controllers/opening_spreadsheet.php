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

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close-edit">&times;</span>
            <form method="post" action="../controllers/edit_job.php">
            <input type="hidden" name="job_id" id="edit-job-id">
            <input type="hidden" name="sheet_id" value="<?php echo $sheet_id; ?>">

        <div class="modal-row">
            <label for="edit-CName">Company:</label>
            <input type="text" name="CName" id="edit-CName" required>
        </div>

        <div class="modal-row">
            <label for="edit-JTitle">Job Title:</label>
            <input type="text" name="JTitle" id="edit-JTitle" required>
        </div>

        <div class="modal-row">
            <label for="edit-Location">Location:</label>
            <input type="text" name="Location" id="edit-Location" required>
        </div>

        <div class="modal-row">
            <label for="edit-Salary">Salary:</label>
            <input type="number" name="Salary" id="edit-Salary">
        </div>

        <div class="modal-row">
            <label for="edit-C_Email">Contact Email:</label>
            <input type="email" name="C_Email" id="edit-C_Email">
        </div>

        <div class="modal-row">
            <label for="edit-C_Phone">Contact Phone:</label>
            <input type="text" name="C_Phone" id="edit-C_Phone">
        </div>

        <div class="modal-row">
            <label for="edit-Date_App">Date Applied:</label>
            <input type="date" name="Date_App" id="edit-Date_App" required>
        </div>

        <div class="modal-row">
            <label for="edit-App_Status">Application Status:</label>
            <input type="text" name="App_Status" id="edit-App_Status">
        </div>

        <button class="edit-job-button" type="submit">Update Job</button>
        </form>
    </div>
    </div>

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
                                <button type="button" 
                                class="open-edit-modal"
                                data-id="<?php echo $job['JobID']; ?>"
                                data-cname="<?php echo htmlspecialchars($job['CName']); ?>"
                                data-jtitle="<?php echo htmlspecialchars($job['JTitle']); ?>"
                                data-location="<?php echo htmlspecialchars($job['Location']); ?>"
                                data-salary="<?php echo htmlspecialchars($job['Salary']); ?>"
                                data-email="<?php echo htmlspecialchars($job['C_Email']); ?>"
                                data-phone="<?php echo htmlspecialchars($job['C_Phone']); ?>"
                                data-date="<?php echo htmlspecialchars($job['Date_App']); ?>"
                                data-status="<?php echo htmlspecialchars($job['App_Status']); ?>">
                                Edit
                                </button>
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

    const editModal = document.getElementById("edit-modal");
    const editButtons = document.querySelectorAll(".open-edit-modal");
    const closeEditBtn = document.querySelector(".close-edit");

    editButtons.forEach(btn => {
        btn.addEventListener("click", () => {
        // grab job data
        document.getElementById("edit-job-id").value = btn.dataset.id;
        document.getElementById("edit-CName").value = btn.dataset.cname;
        document.getElementById("edit-JTitle").value = btn.dataset.jtitle;
        document.getElementById("edit-Location").value = btn.dataset.location;
        document.getElementById("edit-Salary").value = btn.dataset.salary;
        document.getElementById("edit-C_Email").value = btn.dataset.email;
        document.getElementById("edit-C_Phone").value = btn.dataset.phone;
        document.getElementById("edit-Date_App").value = btn.dataset.date;
        document.getElementById("edit-App_Status").value = btn.dataset.status;

        // show modal
        editModal.style.display = "flex";
    });
    })

    closeEditBtn.onclick = () => {
        editModal.style.display = "none";
    };

    window.onclick = (e) => {
        if (e.target === editModal) {
         editModal.style.display = "none";
        }
    };

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
