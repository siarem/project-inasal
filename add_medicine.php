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
if (isset($_POST['name']) && isset($_POST['quantity']) && isset($_POST['expiry_date'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $expiry_date = $_POST['expiry_date'];

    // Insert medicine into the database
    $sql = "INSERT INTO medicines (name, quantity, expiry_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $name, $quantity, $expiry_date);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "medicine" => [
            "name" => $name,
            "quantity" => $quantity,
            "expiry_date" => $expiry_date
        ]]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
}
?>
