<?php
session_start(); // Start session to store feedback messages

// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'kibweziwest';

// Create a new MySQLi connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect input
    $surname = $mysqli->real_escape_string(trim($_POST['surname']));
    $firstName = $mysqli->real_escape_string(trim($_POST['firstName']));
    $otherNames = $mysqli->real_escape_string(trim($_POST['otherNames']));
    $dob = $_POST['dob'];
    $gender = $mysqli->real_escape_string(trim($_POST['gender']));
    $idNumber = $mysqli->real_escape_string(trim($_POST['idNumber']));
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $postalAddress = $mysqli->real_escape_string(trim($_POST['postalAddress']));
    $postalCode = $mysqli->real_escape_string(trim($_POST['postalCode']));
    $subCounty = $mysqli->real_escape_string(trim($_POST['subCounty']));
    $ward = $mysqli->real_escape_string(trim($_POST['ward']));
    $location = $mysqli->real_escape_string(trim($_POST['location']));
    $subLocation = $mysqli->real_escape_string(trim($_POST['subLocation']));
    $village = $mysqli->real_escape_string(trim($_POST['village']));
    $pollingStation = $mysqli->real_escape_string(trim($_POST['pollingStation']));

    // Check for duplicates
    $check_sql = "SELECT id FROM applicants_details WHERE idNumber = ? OR email = ?";
    $check_stmt = $mysqli->prepare($check_sql);
    $check_stmt->bind_param("ss", $idNumber, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "An applicant with the same ID number or email already exists. Repeat again on Applicant details";
    } else {
        $insert_sql = "INSERT INTO applicants_details (
            surname, firstName, otherNames, dob, gender, idNumber, email, 
            postalAddress, postalCode, subCounty, ward, location, subLocation, village, pollingStation
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param("sssssssssssssss", 
            $surname, $firstName, $otherNames, $dob, $gender, $idNumber, $email,
            $postalAddress, $postalCode, $subCounty, $ward, $location, $subLocation, $village, $pollingStation
        );

        if ($stmt->execute()) {
            $message = "Details saved successfully. Continue to Institution Details";
        } else {
            $message = "Failed to save details. Please try again.";
        }

        $stmt->close();
    }

    $check_stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applicant Submission</title>
    <script>
        window.onload = function() {
            alert("<?php echo $message; ?>");
            // Optionally clear form or go back
            window.history.back(); // sends user back to form page
        }
    </script>
</head>
<body>