<?php
session_start();
require_once 'functions/connection.php';
require_once 'vendor/autoload.php'; // Path to the Nexmo PHP library

use Nexmo\Client;

// Your Nexmo API Key and API Secret
$nexmoApiKey = '86922296';
$nexmoApiSecret = 'vMYeM5dkxUOnTJlm';

$nexmo = new Client(new Nexmo\Client\Credentials\Basic($nexmoApiKey, $nexmoApiSecret));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];

    $sql = "SELECT mobile_number FROM members_tbl";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $phone_number =  $row["mobile_number"];

            $nexmo->message()->send([
                'to' => $phone_number,
                'from' => "+639558104499",
                'text' => $message,
            ]);

            $_SESSION['success'] = "Announcement Sent";
            header("Location: events.php");
            exit;
        }
    } else {
        echo "No recipients found.";
    }
}

$conn->close();
