<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Automatically includes PHPMailer classes

$servername = "localhost";
$username = "root";
$password = "";
$database = "login_system"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch medicines expiring within 7 days that haven't been notified yet
$sql = "SELECT medicines.id, medicines.name, medicines.expiry_date, users.email 
        FROM medicines 
        JOIN users ON medicines.user_id = users.id 
        WHERE DATEDIFF(expiry_date, NOW()) <= 7 AND medicines.notified = 0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicine_name = $row['name'];
        $days_left = ceil((strtotime($row['expiry_date']) - time()) / (60 * 60 * 24));
        $user_email = $row['email'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Set the SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // SMTP username
            $mail->Password = 'your_email_password'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@example.com', 'Med Minder');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = 'Medicine Expiry Reminder';
            $mail->Body = "Dear User,<br><br>Your medicine <b>$medicine_name</b> is expiring in $days_left day(s). Please take necessary actions.<br><br>Best regards,<br>Med Minder";

            $mail->send();

            // Mark as notified
            $update_sql = "UPDATE medicines SET notified = 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $row['id']);
            $update_stmt->execute();
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

$conn->close();
?>
