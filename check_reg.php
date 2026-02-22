<?php
// check_reg.php
header('Content-Type: text/plain');
if(!isset($_GET['reg']) || empty($_GET['reg'])) {
    echo "invalid";
    exit;
}

$reg_no = trim($_GET['reg']);

// DB connection
$mysqli = new mysqli('localhost', 'root', '', 'kibweziwest');
if($mysqli->connect_error){
    echo "error";
    exit;
}

// Prepare and execute query
$stmt = $mysqli->prepare("SELECT student_reg_no FROM bursary_student_details WHERE student_reg_no=?");
$stmt->bind_param("s", $reg_no);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0){
    echo "exists";  // Already exists in DB
} else {
    echo "available";  // Free to use
}

$stmt->close();
$mysqli->close();