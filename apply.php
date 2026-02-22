<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli('localhost', 'root', '', 'kibweziwest');
if ($mysqli->connect_error) {
    die("DB Connection Error: " . $mysqli->connect_error);
}

// Initialize user email safely
$user_email = $_SESSION['user_email'] ?? null;

$message = "";

/* -------- HELPER FUNCTION FOR FILE UPLOAD -------- */
function uploadFile($fileInput, $subFolder, $required = false) {
    $baseDir = "uploads/$subFolder/";
    $allowed = ['pdf','jpg','jpeg','png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!empty($_FILES[$fileInput]['name'])) {
        $fileExt = strtolower(pathinfo($_FILES[$fileInput]['name'], PATHINFO_EXTENSION));
        if(!in_array($fileExt, $allowed)) die("Invalid file type for $fileInput.");
        if ($_FILES[$fileInput]['size'] > $maxSize) die("File too large (Max 5MB).");
        if (!is_dir($baseDir)) mkdir($baseDir, 0777, true);
        $filename = uniqid().'_'.preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES[$fileInput]['name']);
        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $baseDir . $filename)) return $filename;
        if ($required) die("Failed to upload required file: $fileInput");
    } elseif ($required) {
        die("Required file not selected: $fileInput");
    }
    return null;
}

/* -------- HANDLE FORM SUBMISSION -------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name      = trim($_POST['student_name'] ?? '');
    $student_reg_no    = trim($_POST['student_reg_no'] ?? '');
    $age               = intval($_POST['age'] ?? 0);
    $village           = trim($_POST['village'] ?? '');
    $location          = trim($_POST['location'] ?? '');
    $sub_county        = trim($_POST['sub_county'] ?? '');
    $family_status     = trim($_POST['family_status'] ?? '');
    $family_occupation = trim($_POST['family_occupation'] ?? '');
    $family_income     = trim($_POST['family_income'] ?? '');
    $institution_name  = trim($_POST['institution_name'] ?? '');
    $course            = trim($_POST['course'] ?? '');
    $course_duration   = trim($_POST['course_duration'] ?? '');

    // Basic server-side validation
    if(empty($student_name) || empty($student_reg_no) || empty($institution_name)){
        die("Please fill all required fields.");
    }

    // Prevent duplicate application
    $check = $mysqli->prepare("SELECT student_reg_no FROM bursary_student_details WHERE student_reg_no=?");
    $check->bind_param("s",$student_reg_no);
    $check->execute();
    $check->store_result();
    if($check->num_rows > 0) die("Application already submitted with this registration number.");

    $fee_structure    = uploadFile('fee_structure', 'fees', true);
    $admission_letter = uploadFile('admission_letter', 'attachments');
    $id_document      = uploadFile('id_document', 'attachments', true);

    $attachmentsList = '';
    if (!empty($_FILES['other_attachments']['name'][0])) {
        $attachDir = "uploads/attachments/";
        if (!is_dir($attachDir)) mkdir($attachDir, 0777, true);
        $attachments = [];
        foreach ($_FILES['other_attachments']['name'] as $key => $file) {
            $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if(!in_array($fileExt, ['pdf','jpg','jpeg','png'])) continue;
            $filename = uniqid().'_'.$file;
            if (move_uploaded_file($_FILES['other_attachments']['tmp_name'][$key], $attachDir.$filename)) {
                $attachments[] = $filename;
            }
        }
        $attachmentsList = implode(',', $attachments);
    }

    $stmt = $mysqli->prepare("
        INSERT INTO bursary_student_details
        (student_name, student_reg_no, age, village, location, sub_county,
         family_status, family_occupation, family_income,
         institution_name, course, course_duration,
         fee_structure, admission_letter, id_document, other_attachments)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    if (!$stmt) die("Prepare Failed: " . $mysqli->error);

    $stmt->bind_param(
        "ssisssssssssssss",
        $student_name,
        $student_reg_no,
        $age,
        $village,
        $location,
        $sub_county,
        $family_status,
        $family_occupation,
        $family_income,
        $institution_name,
        $course,
        $course_duration,
        $fee_structure,
        $admission_letter,
        $id_document,
        $attachmentsList
    );

    if ($stmt->execute()) {
        header("Location: apply.php?success=1");
        exit;
    } else {
        $message = "<div style='background:#ffebee;padding:12px;border-left:5px solid #f44336'>
                    Failed to submit application: ".$stmt->error."
                   </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bursary Application - Kibwezi West NG-CDF</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="apply.css">
</head>
<body>
<div class="header">
    <div>
        <img src="image/cdflogo.png" alt="CDF Logo" style="height:40px; vertical-align:middle;">
        <h1 style="display:inline-block; margin-left:10px;">Kibwezi West Bursary Application</h1>
    </div>
    
</div>

<div class="form-container">
    <h2>Bursary Application Form</h2>
    
    <?php 
    // This will be replaced with your actual PHP message
    $message = ''; 
    ?>
    <?= $message ?>
    
    <?php if(isset($_GET['success'])): ?>
        <div class='success'>
            Application submitted successfully. We'll review your application and get back to you soon.
        </div>
    <?php endif; ?>

    <form method="POST" action="apply.php" enctype="multipart/form-data" id="bursaryForm">
        <div class="section">
            <h4>📋 Student Details</h4>
            <div class="form-grid">
                <div>
                    <input type="text" id="student_name" name="student_name" placeholder="Student Full Name" required>
                    <small class="error" id="nameError"></small>
                </div>
                
                <div>
                    <input type="text" id="student_reg_no" name="student_reg_no" placeholder="Registration Number" required>
                    <small class="error" id="regError"></small>
                </div>
                
                <div>
                    <input type="number" id="age" name="age" placeholder="Age" required>
                    <small class="error" id="ageError"></small>
                </div>
                
                <div>
                    <input type="text" id="village" name="village" placeholder="Village">
                    <small class="error" id="villageError"></small>
                </div>
                
                <div>
                    <input type="text" id="location" name="location" placeholder="Location">
                    <small class="error" id="locationError"></small>
                </div>
                
                <div>
                    <input type="text" id="sub_county" name="sub_county" placeholder="Sub-County">
                    <small class="error" id="subcountyError"></small>
                </div>
            </div>
        </div>

        <div class="section">
            <h4>👪 Family Information</h4>
            <div class="form-grid">
                <div>
                    <select id="family_status" name="family_status" required>
                        <option value="">-- Select Family Status --</option>
                        <option value="Orphan">Orphan (Both parents deceased)</option>
                        <option value="Single Parent">Single Parent</option>
                        <option value="Poor">Poor / Vulnerable</option>
                    </select>
                    <small class="error" id="statusError"></small>
                </div>
                
                <div>
                    <input type="text" id="family_occupation" name="family_occupation" placeholder="Family Occupation (e.g., Farming)">
                    <small class="error" id="occupationError"></small>
                </div>
                
                <div>
                    <input type="number" id="family_income" name="family_income" placeholder="Monthly Income (KES)">
                    <small class="error" id="incomeError"></small>
                </div>
            </div>
        </div>

        <div class="section">
            <h4>🎓 Education Information</h4>
            <div class="form-grid">
                <div>
                    <input type="text" id="institution_name" name="institution_name" placeholder="Institution Name" required>
                    <small class="error" id="instError"></small>
                </div>
                
                <div>
                    <input type="text" id="course" name="course" placeholder="Course of Study" required>
                    <small class="error" id="courseError"></small>
                </div>
                
                <div>
                    <input type="text" id="course_duration" name="course_duration" placeholder="Duration (Years)">
                    <small class="error" id="durationError"></small>
                </div>
            </div>
        </div>

        <div class="section">
            <h4>📎 Attachments</h4>
            <div class="form-grid">
                <div>
                    <label>📄 Fee Structure <span class="required-indicator">*</span></label>
                    <input type="file" id="fee_structure" name="fee_structure" required>
                    <small class="error" id="feeError"></small>
                </div>

                <div>
                    <label>📑 Admission Letter (Optional)</label>
                    <input type="file" id="admission_letter" name="admission_letter">
                    <small class="error" id="admissionError"></small>
                </div>

                <div>
                    <label>🆔 ID Card / Birth Certificate <span class="required-indicator">*</span></label>
                    <input type="file" id="id_document" name="id_document" required>
                    <small class="error" id="idError"></small>
                </div>

                <div>
                    <label>📁 Other Supporting Documents</label>
                    <input type="file" id="other_attachments" name="other_attachments[]" multiple>
                    <small class="error" id="otherError"></small>
                    <small class="help-text">Hold Ctrl/Cmd to select multiple files</small>
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn" id="submitBtn">📨 Submit Application</button>
    </form>
</div>

<div class="footer">
    © <?= date("Y"); ?> Kibwezi West NG-CDF | Empowering Education, Transforming Lives
</div>
<script>
// Real-time validation functions
function showError(input,message,errorId){input.classList.add("invalid");input.classList.remove("valid");document.getElementById(errorId).innerText=message;}
function showSuccess(input,errorId){input.classList.remove("invalid");input.classList.add("valid");document.getElementById(errorId).innerText="";}

// Validation rules
document.getElementById("student_name").addEventListener("input",()=>{let i=document.getElementById("student_name");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid name","nameError"):showSuccess(i,"nameError");});

document.getElementById("student_reg_no").addEventListener("input",()=>{let i=document.getElementById("student_reg_no");i.value.length<3?showError(i,"Reg number too short","regError"):showSuccess(i,"regError");});

// AJAX check registration
document.getElementById("student_reg_no").addEventListener("blur",()=>{
let reg=document.getElementById("student_reg_no").value;
if(reg.length<3) return;
fetch("check_reg.php?reg="+reg).then(r=>r.text()).then(data=>{data==="exists"?showError(document.getElementById("student_reg_no"),"Already exists","regError"):showSuccess(document.getElementById("student_reg_no"),"regError");});
});

document.getElementById("age").addEventListener("input", () => {let a = parseInt(document.getElementById("age").value, 10);(isNaN(a) || a < 16 || a > 35)? showError(document.getElementById("age"), "Enter valid age (16-35)", "ageError"):showSuccess(document.getElementById("age"), "ageError");});
document.getElementById("village").addEventListener("input",()=>{let i=document.getElementById("village");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid name","villageError"):showSuccess(i,"villageError");});
document.getElementById("location").addEventListener("input",()=>{let i=document.getElementById("location");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid name","locationError"):showSuccess(i,"locationError");});
document.getElementById("sub_county").addEventListener("input",()=>{let i=document.getElementById("sub_county");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid name","subcountyError"):showSuccess(i,"subcountyError");});

document.getElementById("family_status").addEventListener("change",()=>{let s=document.getElementById("family_status");s.value===""?showError(s,"Select status","statusError"):showSuccess(s,"statusError");});
document.getElementById("family_occupation").addEventListener("input",()=>{let i=document.getElementById("family_occupation");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid occupation","occupationError"):showSuccess(i,"occupationError");});
document.getElementById("family_income").addEventListener("input",()=>{let n=parseInt(document.getElementById("family_income").value);isNaN(n)||n<0?showError(document.getElementById("family_income"),"Invalid income","incomeError"):showSuccess(document.getElementById("family_income"),"incomeError");});

document.getElementById("institution_name").addEventListener("input",()=>{let i=document.getElementById("institution_name");!/^[A-Za-z\s]{3,}$/.test(i.value)?showError(i,"Enter valid name","instError"):showSuccess(i,"instError");});
document.getElementById("course").addEventListener("input",()=>{let i=document.getElementById("course");!/^[A-Za-z\s.]{3,}$/.test(i.value)?showError(i,"Enter valid name","courseError"):showSuccess(i,"courseError");});
document.getElementById("course_duration").addEventListener("input",()=>{let a = parseInt(document.getElementById("course_duration").value, 10);(isNaN(a) || a < 1 || a > 7)? showError(document.getElementById("course_duration"), "Enter valid duration (1-7 years)", "durationError"):showSuccess(document.getElementById("course_duration"), "durationError");});

// File validation
document.getElementById("fee_structure").addEventListener("change",()=>{let f=document.getElementById("fee_structure");f.files[0]?.size>5242880?showError(f,"Max 5MB","feeError"):showSuccess(f,"feeError");});
document.getElementById("id_document").addEventListener("change",()=>{let f=document.getElementById("id_document");f.files[0]?.size>5242880?showError(f,"Max 5MB","idError"):showSuccess(f,"idError");});

// Prevent submit if invalid
document.getElementById("bursaryForm").addEventListener("submit",(e)=>{
if(document.querySelectorAll(".invalid").length>0){e.preventDefault();alert("Correct highlighted fields first.");}
});
</script>

</body>
</html>