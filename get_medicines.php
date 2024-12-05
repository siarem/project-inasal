<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_system"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicines";
$result = $conn->query($sql);

$medicines = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

echo json_encode($medicines);

$conn->close();
?>
