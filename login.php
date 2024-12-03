<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "login_system"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure POST data is received
if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $form_username = $_POST['user_name'];
    $form_password = $_POST['password'];

    // Query the database for the user
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $form_username, $form_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($form_password, $user['password'])) {
            // Successful login
            header("Location: afterlogin.html"); // Redirect to afterlogin.html
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username or email";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    echo "Please fill in both username and password";
}
?>
