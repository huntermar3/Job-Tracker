<?php

// read .env file line by line
$env = [];
$lines = file(__DIR__ . '../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    // skip comments
    if (strpos(trim($line), '#') === 0) continue;

    // split into key and value
    [$key, $value] = explode('=', $line, 2);
    $env[trim($key)] = trim($value);
}

// get database credentials from $env
$servername = $env['DB_HOST'] ?? 'localhost';
$username   = $env['DB_USER'] ?? 'root';
$password   = $env['DB_PASS'] ?? '';
$dbname     = $env['DB_NAME'] ?? 'job_tracker';

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

echo "Connected successfully";
?>
