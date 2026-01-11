<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Dummy data for display (replace with actual database queries)
$applicantDetails = "Name: John Doe<br>Email: john.doe@example.com<br>Status: Active";
$institutionDetails = "Institution: Example University<br>Program: Computer Science";
$attachments = "<ul><li>Document1.pdf</li><li>Document2.jpg</li></ul>";
$applicationForm = "<form action='submit_application.php' method='POST'>
                        <label for='bursaryAmount'>Requested Bursary Amount:</label>
                        <input type='number' name='bursaryAmount' required>
                        <br>
                        <input type='submit' value='Submit Application'>
                    </form>";
$status = "Application Status: Pending";
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
        /* Basic Styles */
        .container { display: flex; flex-wrap: wrap; }
        .sidebar { width: 20%; background-color: #333; color: #eaf0f1; padding: 20px; }
        .content { width: 80%; padding: 20px; }
        .menu-icon { display: none; font-size: 1.5rem; cursor: pointer; color: #333; }
        
        /* Footer Styles */
        footer {
            background-color: #333;
            color: #eaf0f1;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Mobile Sidebar Styles */
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; } /* Set full width */
            .menu-icon { display: block; padding: 10px; }
            .sidebar.hidden { display: none; } /* Hide sidebar when not needed */
            .content.hidden { display: none; } /* Hide content when not needed */
        }
    </style>
</head>
<body>
<header>
    <img src="image/cdflogo.png" alt="CDF Logo" class="header-logo">
    <h1 style="color: rgb(15, 15, 15); font-size: 20px;">Kibwezi West Constituency Bursary Application</h1>
    <span class="menu-icon" onclick="toggleMenu()">
        <i class="fas fa-bars"></i> <!-- Font Awesome icon for menu -->
    </span>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <!-- Sidebar Menu -->
    <div class="sidebar" id="sidebar">
        <h2>Applicants Profile</h2>
        <h2><a href="#" onclick="loadContent('applicantDetails.php')">Applicant Details</a></h2>
       <!-- <h2><a href="#" onclick="loadContent('institutionDetails.php')">Institution Details</a>
        <h2><a href="#" onclick="loadContent('attachments.php')">Attachments</a>
        <h2><a href="#" onclick="loadContent('apply.php')">Apply for Bursary</a></h2>---->
        <h2><a href="#" onclick="loadContent('status.php')">Application Status</a></h2>        
        
    </div>

    <!-- Main Content Area -->
    <div class="content" id="displayArea">
        <h2>Welcome to Kibwezi West Bursary Application!</h2>
        <h1 style="text-decoration:underline;">DISCLAIMER</h1>
        <p>
            <h2><b>Important Notice:</b></h2><br>
            The information provided in this bursary application system is for the purpose of applying for financial assistance only and may change without notice.
            <br><br><b>By submitting your application, you acknowledge that:</b><br>
            <b>Eligibility:</b> Ensure you meet the eligibility criteria before applying.<br>
            <b>Data Protection:</b> Your personal information will be processed in accordance with data protection laws and will only be used for application purposes.
            <br><b>No Guarantees:</b> Submitting an application does not guarantee funding. All applications are subject to review and approval.
            <br><b>Changes:</b> We may amend the terms of the bursary at any time.<br> Check the website regularly for updates.
           <br><b>Limitation of Liability:</b> We are not liable for any damages arising from the use of this system.
        </p>
    </div>
</div>

<footer style="background-color:purple;margin-top:10%;">
    <p>&copy; 2024 Kibwezi West Constituency Bursary Application. All rights reserved.</p>
    <p><a href="#terms" style="color: #eaf0f1;">Terms and Conditions</a> | <a href="#privacy" style="color: #eaf0f1;">Privacy Policy</a></p>
</footer>



<script>
    // Toggle mobile sidebar visibility
    function toggleMenu() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    }

    // Load content dynamically and hide the sidebar
    function loadContent(page) {
    const displayArea = document.getElementById('displayArea');
    const sidebar = document.getElementById('sidebar');

    sidebar.classList.add('hidden');
    displayArea.innerHTML = "<p>Loading...</p>";

    fetch(page)
        .then(response => response.text())
        .then(html => {
            // Insert the HTML
            displayArea.innerHTML = html;
            
            // Find and execute all scripts in the loaded content
            const scripts = displayArea.querySelectorAll('script');
            scripts.forEach(script => {
                const newScript = document.createElement('script');
                newScript.textContent = script.textContent;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
            });
        })
        .catch(error => {
            displayArea.innerHTML = "<p>Error loading content. Please try again later.</p>";
            console.error('Error:', error);
        });
}
</script>
</body>
</html>