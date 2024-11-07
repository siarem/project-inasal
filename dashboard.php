<?php
session_start(); // Check if user is logged in

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: index.html");
    exit();
}
?>

<h1>Welcome to the Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
<p>This is your dashboard, accessible only after login.</p>
