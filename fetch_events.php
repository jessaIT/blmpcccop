<?php
include("functions/connection.php");

// Query to fetch event dates and titles from the database
$sql = "SELECT event_date, event_name FROM events_tbl";
$result = $conn->query($sql);

$eventData = [];

while ($row = $result->fetch_assoc()) {
    // Store the event data with the date as the key and title as the value
    $eventData[$row['event_date']] = $row['event_name'];
}

// Return the event data as JSON
header('Content-Type: application/json');
echo json_encode($eventData);

