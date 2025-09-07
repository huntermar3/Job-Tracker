<?php

// read .env file line by line
$env = [];
$lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    // skip comments
    if (strpos(trim($line), '#') === 0) continue;

    // split into key and value
    [$key, $value] = explode('=', $line, 2);
    $env[trim($key)] = trim($value);
}

// get database credentials from $env
define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
define('DB_USER', $env['DB_USER'] ?? 'root');
define('DB_PASS', $env['DB_PASS'] ?? '');
define('DB_NAME', $env['DB_NAME'] ?? 'job_tracker');

// create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// echo "Connected successfully";
?>
