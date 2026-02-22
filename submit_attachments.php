<?php
session_start();

// Database configuration
$db_username = 'root';
$db_password = '';
$db_name = 'kibweziwest';
$db_host = 'localhost';

// Create a new MySQLi connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$uploadDir = 'uploads/';
$allowedTypes = ['pdf', 'docx', 'jpg', 'jpeg', 'png'];

// ✅ Check if files already submitted by this user
$checkSql = "SELECT id FROM attachments WHERE user_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("i", $userId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo "You have already submitted your documents.";
    exit();
}

// 🗂 Upload Function
function uploadFile($fileInputName, $isMultiple = false) {
    global $uploadDir, $allowedTypes;

    if ($isMultiple && isset($_FILES[$fileInputName])) {
        $files = $_FILES[$fileInputName];
        $uploadedFiles = [];

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === 0) {
                $fileName = basename($files['name'][$i]);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExt, $allowedTypes)) {
                    $newName = uniqid() . "_" . $fileName;
                    $filePath = $uploadDir . $newName;

                    if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                        $uploadedFiles[] = $newName;
                    }
                }
            }
        }

        return json_encode($uploadedFiles); // Store as JSON string
    }

    if (!empty($_FILES[$fileInputName]['name'])) {
        $fileName = basename($_FILES[$fileInputName]['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedTypes)) {
            $newName = uniqid() . "_" . $fileName;
            $filePath = $uploadDir . $newName;

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $filePath)) {
                return $newName;
            }
        }
    }

    return null;
}

// 📤 Upload each file
$birthCert = uploadFile('birthCertificate');
$admission = uploadFile('admissionLetter');
$fees = uploadFile('feesStructure');
$faith = uploadFile('faithLetter');
$others = uploadFile('otherDocuments', true);

// 💾 Insert into DB
$sql = "INSERT INTO attachments (user_id, birth_certificate, admission_letter, fees_structure, faith_letter, other_documents)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $userId, $birthCert, $admission, $fees, $faith, $others);

if ($stmt->execute()) {
    echo "Files uploaded and recorded successfully!";
    // header("Location: apply.php");
} else {
    echo "Error: " . $stmt->error;
}
?>
