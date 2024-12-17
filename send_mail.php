<?php

// Load PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $location = htmlspecialchars(trim($_POST['location']));

    // Validate form fields
    if (empty($name) || empty($email) || empty($mobile) || empty($location)) {
        die("All fields are required.");
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP server (e.g., Gmail, SendGrid, etc.)
        $mail->SMTPAuth = true;
        $mail->Username = 'rdigininja@gmail.com'; // SMTP username
        $mail->Password = 'hszkdqngibkjwwlu';        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // Use 465 for SSL

        // Sender and recipient
        $mail->setFrom($email, $name);
        $mail->addAddress('rdigininja@gmail.com');  // Replace with your recipient email

        // Email subject and body
        $mail->Subject = 'New Test Ride Request - Access 125';
        $mail->Body = "You have received a new Test Ride request.\n\n";
        $mail->Body .= "Name: $name\n";
        $mail->Body .= "Email: $email\n";
        $mail->Body .= "Mobile Number: $mobile\n";
        $mail->Body .= "Location: $location\n\n";
        $mail->Body .= "Regards,\nBook a Test Ride Form";

         // Send email
         if ($mail->send()) {
            echo "<div class='success'>Your request has been submitted successfully!</div>";
        } else {
            echo "<div class='error'>Sorry, there was an error sending your request. Please try again later.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>Mailer Error: {$mail->ErrorInfo}</div>";
    }
} else {
    echo "<div class='error'>Invalid form submission.</div>";
}
?>