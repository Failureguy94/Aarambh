<?php
// Database configuration
$host = 'localhost';      // Database host (usually localhost)
$dbname = 'lifelink_db';  // Database name
$username = 'root';        // Database username
$password = '';            // Database password (empty for XAMPP/WAMP default)

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");

// Optional: Uncomment to see connection success message during testing
// echo "Connected successfully";
?>
