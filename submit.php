<?php
// Database connection
$servername = "localhost";
$username = "root"; // Changed variable name to avoid conflict
$password = ""; 
$database = "login_system"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$form_username = $_POST['username'];  // Changed to avoid conflict
$form_email = $_POST['email'];
$form_password = $_POST['password'];

// Hash the password before storing it
$hashed_password = password_hash($form_password, PASSWORD_BCRYPT); // Use BCRYPT for hashing

// Insert user into the database using a prepared statement
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"; // Make sure these column names match your database schema
$stmt = $conn->prepare($sql);

// Bind the parameters (sss means 3 string parameters)
$stmt->bind_param("sss", $form_username, $form_email, $hashed_password);

// Execute the query
if ($stmt->execute()) {
    echo "Sign-up successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
