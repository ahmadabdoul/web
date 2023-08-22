<?php
// db
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'porcode_db';
$port = 3306;

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
