<?php
session_start();
include 'connection.php';

// Include the Google API client library
require __DIR__ . '../../vendor/autoload.php'; // Adjust the path as needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_date = $_POST['event_date'];
    $outputDate = date('Y/m/d', strtotime($event_date));
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];

    $dateCheckQuery = "SELECT COUNT(*) AS event_count FROM events_tbl WHERE event_date = '$event_date'";
    $dateResult = $conn->query($dateCheckQuery);

    if ($dateResult) {
        $eventCount = $dateResult->fetch_assoc()['event_count'];
        if ($eventCount > 0) {
            $_SESSION['error'] = "An event already exists for the selected date.";
        } else {

            if (!empty($_FILES['image']['name'])) {
                $imageFileName = $_FILES['image']['name'];
                $imageTmpName = $_FILES['image']['tmp_name'];
                $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));


                if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $uploadDir = 'events_banner/';

                    $imageFile = $uploadDir . uniqid() . '.' . $imageFileType;

                    if (move_uploaded_file($imageTmpName, $imageFile)) {
                        $sql = "INSERT INTO events_tbl(event_name, event_date, event_description, image_path) VALUES('$event_name', '$event_date', '$event_description', '$imageFile')";
                        
                        if ($conn->query($sql) === TRUE) { 
                        // if (true) { 

                            $serviceAccountFilePath = 'config/googleCalendar.json';

                            // Set up the Google API client with the service account credentials
                            $client = new Google_Client();
                            $client->setAuthConfig($serviceAccountFilePath);
                            $client->addScope(Google\Service\Calendar::CALENDAR);
                            $client->setAccessType('offline');
                            $client->getAccessToken();
                            $client->getRefreshToken(); 
                        

                            // Set up the Google Calendar service
                            $service = new Google\Service\Calendar($client);

                            // Submit the event
                            $calendarId = 'padayhagjessa@gmail.com';

                            $event = new Google\Service\Calendar\Event(array(
                                'summary' => $event_name,
                                'description' => $event_description,
                                'start' => array(
                                    'dateTime' => $event_date.'T00:00:00',
                                    'timeZone' => 'Asia/Manila',
                                ),
                                'end' => array(
                                    'dateTime' => $event_date.'T23:59:59',
                                    'timeZone' => 'Asia/Manila',
                                ),
                            ));

                            $event = $service->events->insert($calendarId, $event);
                            
                            $notify = notifyUsersByEmail($event_name, $event_description, $event->start->dateTime, $event->htmlLink);


                            if ($event) {
                                $_SESSION['success'] .= " Event added to Google Calendar";
                            } else {
                                $_SESSION['error'] = "Error creating event in Google Calendar.";
                            }


                        } else {
                            $_SESSION['error'] = "Error: " . $conn->error;
                        }
                    } else {
                        $_SESSION['error'] = "Error uploading image.";
                    }
                } else {
                    $_SESSION['error'] = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
                }
            } else {
                $_SESSION['error'] = "Please select an image.";
            }
        }
    }

    header("Location: ../events.php");
    exit;
}


// Function to send email notifications
function notifyUsersByEmail($eventTitle, $eventDescription, $eventDateTime, $calendarLink)
{
    include 'connection.php';

    $mail = new PHPMailer();

    try { 
 
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '5630f30ec162e4';
        $mail->Password = '3553fa0d9d120d';

        // Recipients (replace with actual user emails)
        $dateCheckQuery = "SELECT email FROM members_tbl WHERE 1";
        $dateResult = $conn->query($dateCheckQuery);

        $recipientEmails = [];

        // Loop through database results if applicable
        while ($row = $dateResult->fetch_assoc()) {
            $recipientEmails[] = $row['email'];
        }

        foreach ($recipientEmails as $recipientEmail) {
            $mail->addAddress($recipientEmail);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Event: ' . $eventTitle;
        $mail->Body    = '<p><strong>' . $eventTitle . '</strong></p>
        <p>' . $eventDescription . '</p>
        <p>Event Time: ' . $eventDateTime . '</p>'.
        '<p>Event Calendar Link: ' . $calendarLink . '</p>';

        // Send email
        $mail->send();
        echo 'Email notification sent successfully.';
    } catch (Exception $e) {
        echo 'Email notification failed. Error: ', $mail->ErrorInfo;
    }
}