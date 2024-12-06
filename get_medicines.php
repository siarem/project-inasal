<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_system"; // Replace this with your actual database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, quantity, expiry_date FROM medicines";
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
