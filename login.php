<?php
include 'connect.php'; // Include database connection file

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to retrieve user details
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "Login successful!"; // Placeholder response
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that username!";
    }

    // Close the database connection
    $conn->close();
}
?>
