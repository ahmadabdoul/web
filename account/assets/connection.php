<?php

// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'porcode_db';
$DOMAIN = "5sim.net";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    $response = array(
        'success' => false,
        'message' => 'Database connection failed: ' . mysqli_connect_error()
    );
    echo json_encode($response);
    exit;
}

?>
