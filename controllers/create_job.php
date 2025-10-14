<?php
require_once "../config/database.php";
session_start();

// Get job info from post in openening_spreadsheet.php
$SheetId = $_POST['sheet_id'];
$CName = $_POST['CName'];
$JTitle = $_POST['JTitle'];
$Location = $_POST['Location'];
$Salary = $_POST['Salary'];
$CEmail = $_POST['C_Email'];
$CPhone = $_POST['C_Phone'];
$DateApp = $_POST['Date_App'];
$AppStatus = $_POST['App_Status'];

$job_params = array($CName, $JTitle, $Location, $Salary, $CEmail, $CPhone, $DateApp, $AppStatus);

// Make sure all the fields have stuff
foreach ($job_params as $p) {
    if (empty($p)) {
        echo "<script>
                alert('Please fill out all fields!');
                window.location.href = '../views/dashboard.php';
              </script>";
        
    }
}

// Insert
$DateApp = date('Y-m-d');
$sql = $conn->prepare("INSERT INTO JOB_LISTING (Spreadsheet_id, CName, JTitle, Location, Salary, C_Email, C_Phone, Date_App, App_Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("isssissss", $SheetId, $CName, $JTitle, $Location, $Salary, $CEmail, $CPhone, $DateApp, $AppStatus);
$sql->execute();

// Return
echo "<script>
        alert('Job added successfully!');
        window.location.href = 'opening_spreadsheet.php?sheet_id=".$SheetId."';
      </script>";

?>