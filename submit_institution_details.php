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

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $institutionName = $mysqli->real_escape_string(trim($_POST['institutionName'] ?? ''));
    $course = $mysqli->real_escape_string(trim($_POST['course'] ?? ''));
    $registrationNumber = $mysqli->real_escape_string(trim($_POST['registrationNumber'] ?? ''));
    $yearOfStudy = intval($_POST['yearOfStudy'] ?? 0);
    $institutionAddress = $mysqli->real_escape_string(trim($_POST['institutionAddress'] ?? ''));
    $institutionPhone = $mysqli->real_escape_string(trim($_POST['institutionPhone'] ?? ''));
    $institutionEmail = $mysqli->real_escape_string(trim($_POST['institutionEmail'] ?? ''));
    $dateOfAdmission = $mysqli->real_escape_string(trim($_POST['dateOfAdmission'] ?? ''));
    $courseDuration = $mysqli->real_escape_string(trim($_POST['courseDuration'] ?? ''));

    // Basic duplicate check: check if the registration number already exists
    $check_sql = "SELECT 1 FROM institution_details WHERE registration_number = ?";
    $check_stmt = $mysqli->prepare($check_sql);
    $check_stmt->bind_param("s", $registrationNumber);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "Institution details with this registration number have already been submitted.";
    } else {
        // Insert institution details
        $insert_sql = "INSERT INTO institution_details (
            institution_name, course, registration_number, year_of_study, 
            institution_address, institution_phone, institution_email, date_of_admission, course_duration
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param(
            "sssisssss",
            $institutionName, $course, $registrationNumber, $yearOfStudy,
            $institutionAddress, $institutionPhone, $institutionEmail, $dateOfAdmission, $courseDuration
        );

        if ($stmt->execute()) {
            $message = "Institutional details saved successfully.";
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
    <title>Institution Details Submission</title>
    <script>
        window.onload = function() {
            alert("<?php echo $message; ?>");
            <?php if ($message === "Institutional details saved successfully.") : ?>
                window.location.href = "attachments.php";
            <?php else : ?>
                window.history.back();
            <?php endif; ?>
        }
    </script>
</head>
<body>
</body>
</html>
