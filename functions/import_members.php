<?php
session_start();
include('connection.php');

// Import function
function importCSV($filePath, $conn)
{
    // Check if the file exists
    if (!file_exists($filePath)) {
        return false;
    }

    // Open the file for reading
    $file = fopen($filePath, 'r');

    // Skip the first line (header)
    fgetcsv($file);

    $lastMemId = null;

    // Read data from the file and insert into the database
    while (($data = fgetcsv($file)) !== false) {
 

        $id = $data[0];
        $firstname = $data[1];
        $middlename = $data[2];
        $lastname = $data[3];
        $extension = $data[4];
        $dob = $data[5];
        $age = $data[6];
        $pob = $data[7];
        $civil_status = $data[8];
        $tin = $data[9];
        $mobile_number = $data[10];
        $email = $data[11];
        $zone = $data[12];
        $brgy = $data[13];
        $municipality = $data[14];
        $province = $data[15];
        $status = $data[16]; 
        $image_path = '';

        // Get the last entry's mem_id
        $getLastIdStmt = $conn->prepare("SELECT MAX(mem_id) FROM members_tbl");
        $getLastIdStmt->execute();
        $getLastIdStmt->bind_result($lastMemId);
        $getLastIdStmt->fetch();
        $getLastIdStmt->close();

        // Increment the last mem_id for the new entry
        $mem_id = $lastMemId !== null ? $lastMemId + 1 : 1;

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO `members_tbl` (`id`, `mem_id`, `firstname`, `middlename`, `lastname`, `extension`, `dob`, `age`, `pob`, `civil_status`, `tin`, `mobile_number`, `email`, `zone`, `brgy`, `municipality`, `province`, `region`, `image_path`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


        $stmt->bind_param("sssssssssssssssssss", $id, $mem_id, $firstname, $middlename, $lastname, $extension, $dob, $age, $pob, $civil_status, $tin, $mobile_number, $email, $zone, $brgy, $municipality, $province, $image_path, $status);

        $stmt->execute(); 
        $stmt->close();
    }

    // Close the file
    fclose($file);

    return true;
}

// Example usage
if (isset($_FILES['csv_file'])) {
    $fileTmpPath = $_FILES['csv_file']['tmp_name'];

    if (importCSV($fileTmpPath, $conn)) {
        header('Location: ../index.php?success=1');
        $_SESSION['success'] = "Importing members run successfully!";
        exit;
    } else {
        header('Location: ../index.php?error=1');
        $_SESSION['error'] = "Importing members run failed!";
        exit;
    }

}

$conn->close();
?>
