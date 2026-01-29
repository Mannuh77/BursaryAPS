<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Logged-in user email
$user_email = $_SESSION['email'];

// TEMP: replace with DB query later
$applicationStatus = null; // null | draft | submitted | approved | rejected
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="dashboard.css">
<style>
    body { margin:0; font-family: Arial, sans-serif; }

    /* Header / Navbar */
    header { 
        background: linear-gradient(to right, #eaf0f1, #1e5735); 
        color:#000; 
        padding:15px; 
        display:flex; 
        align-items:center; 
        justify-content:space-between; 
        border-bottom: 2px solid #1e5735;
    }
    header h1 { font-size:20px; margin:0; color:#000; }
    header nav ul { list-style:none; margin:0; padding:0; display:flex; align-items:center; }
    header nav ul li { margin-left:15px; }
    header nav ul li a { color:#eaf0f1; text-decoration:none; font-weight:bold; }
    header .user-email { font-weight:bold; color:#eaf0f1; }

    /* Container */
    .container { display:flex; flex-wrap:wrap; min-height:80vh; }

    /* Sidebar */
    .sidebar { width:20%; background:#333; color:#eaf0f1; padding:20px; }
    .sidebar h2, .sidebar h3 { color:#eaf0f1; }
    .sidebar h3 a { color:#eaf0f1; text-decoration:none; }
    .sidebar h3 a:hover { text-decoration:underline; }

    /* Content */
    .content { width:80%; padding:20px; }

    /* Footer */
    footer { background:purple; color:#fff; text-align:center; padding:10px 0; margin-top:10px; }

    /* Responsive */
    @media(max-width:768px) {
        .container { flex-direction:column; }
        .sidebar { width:100%; }
        .sidebar.hidden { display:none; }
    }
</style>
</head>
<body>

<header>
    <div>
        <img src="image/cdflogo.png" alt="CDF Logo" style="height:40px; vertical-align:middle;">
        <h1 style="display:inline-block; margin-left:10px;">Kibwezi West Bursary Application</h1>
    </div>
    <nav>
        <ul>
            <li class="user-email"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($user_email) ?></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h2>Applicant Profile</h2>

        <h3><a href="javascript:void(0)" onclick="loadContent('applicantDetails.php')">Applicant Profile</a></h3>

        <?php if ($applicationStatus === null): ?>
            <h3><a href="javascript:void(0)" onclick="loadContent('apply.php')">Apply for Bursary</a></h3>
        <?php elseif ($applicationStatus === 'draft'): ?>
            <h3><a href="javascript:void(0)" onclick="loadContent('apply.php')">Continue Application</a></h3>
        <?php else: ?>
            <h3><a href="javascript:void(0)" onclick="loadContent('status.php')">Application Status</a></h3>
        <?php endif; ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content" id="displayArea">
        <h2>Welcome to Kibwezi West Bursary Application</h2>

        <?php if ($applicationStatus === null): ?>
            <div style="background:#eef; padding:15px; border-left:5px solid #3f51b5;">
                👉 Please complete your bursary application to proceed.
            </div>
        <?php elseif ($applicationStatus === 'submitted'): ?>
            <div style="background:#fff3cd; padding:15px; border-left:5px solid #ff9800;">
                ⏳ Your application has been submitted and is under review.
            </div>
        <?php elseif ($applicationStatus === 'approved'): ?>
            <div style="background:#e8f5e9; padding:15px; border-left:5px solid #4caf50;">
                ✅ Congratulations! Your bursary has been approved.
            </div>
        <?php elseif ($applicationStatus === 'rejected'): ?>
            <div style="background:#ffebee; padding:15px; border-left:5px solid #f44336;">
                ❌ Unfortunately, your application was rejected.
            </div>
        <?php endif; ?>

        <hr>
        <h2>Important Notice</h2>
        <p>The information provided is for bursary application purposes and may change without notice.</p>
        <ul>
            <li><strong>Eligibility:</strong> Ensure you meet the criteria.</li>
            <li><strong>Data Protection:</strong> Your data is processed according to the law.</li>
            <li><strong>No Guarantee:</strong> Submission does not guarantee funding.</li>
            <li><strong>Changes:</strong> Terms may change without notice.</li>
            <li><strong>Liability:</strong> The constituency is not liable for system misuse.</li>
        </ul>
    </div>
</div>

<footer>
    <p>&copy; 2024 Kibwezi West Constituency Bursary Application</p>
</footer>

<script>
function toggleMenu() {
    document.getElementById('sidebar').classList.toggle('hidden');
}

function loadContent(page) {
    const allowedPages = ['applicantDetails.php','apply.php','status.php'];
    if(!allowedPages.includes(page)){
        document.getElementById('displayArea').innerHTML = "<p>Access denied.</p>";
        return;
    }

    const displayArea = document.getElementById('displayArea');
    const sidebar = document.getElementById('sidebar');
    if(window.innerWidth <= 768) sidebar.classList.add('hidden');

    displayArea.innerHTML = "<p>Loading...</p>";
    fetch(page)
        .then(res => res.text())
        .then(html => displayArea.innerHTML = html)
        .catch(() => displayArea.innerHTML = "<p>Error loading content.</p>");
}
</script>

</body>
</html>
