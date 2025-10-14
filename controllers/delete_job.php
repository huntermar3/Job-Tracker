<?php
require_once "../config/database.php";
session_start();

// Get job info from post in openening_spreadsheet.php
$job_id = $_POST['job_id'];
$sheet_id = $_POST['sheet_id'];

// Delete
$sql = $conn->prepare("DELETE FROM JOB_LISTING WHERE JobID=? AND Spreadsheet_id=?");
$sql->bind_param("ii", $job_id, $sheet_id);
$sql->execute();

// Return
echo "<script>
        alert('Job deleted successfully!');
        window.location.href = 'opening_spreadsheet.php?sheet_id=".$sheet_id."';
      </script>";

?>