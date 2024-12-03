<?php
// db_connect.php
$servername = "localhost";  // Database server
$db_username = "root";      // Database username (usually "root" for XAMPP by default)
$db_password = "";          // Database password (default is empty for XAMPP)
$dbname = "login_system";    // Your database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Stops execution if connection fails
}
?>
