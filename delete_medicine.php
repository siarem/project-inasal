<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_system"; // Replace this with your actual database name

header('Content-Type: application/json'); // Ensure the content type is JSON

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Ensure POST data is received
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete medicine from the database
    $sql = "DELETE FROM medicines WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid ID"]);
}
?>
