<?php
session_start();
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    $csvFile = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($csvFile, 'r');
    include('connection.php');

    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        if (empty(array_filter($data))) {
            continue; 
        }
        
        $random_number = rand(1000, 9999);
        $currDate = date("Ymd");
        $mem_id = $currDate . $random_number;
        $sql = "INSERT INTO members_tbl (mem_id, firstname, middlename, lastname, extension, dob, age, pob, civil_status, tin, mobile_number, email, zone, brgy, municipality, province, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssssssss", $mem_id, ...$data);
        $stmt->execute();
    }
    
    fclose($handle);
    $conn->close();
    header('Location: ../index.php?success=1');
    $_SESSION['success'] = "Importing members run successfully!";
    exit;
} else {
    header('Location: ../index.php?error=1');
    $_SESSION['success'] = "Importing members run failed!";
    exit;
}
?>
