<?php
session_start();
include 'connection.php';

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
                            $_SESSION['success'] = "New Event Added!";
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
