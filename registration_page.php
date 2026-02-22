
<?php
session_start(); // Start the session to access session variables

// Check if there's a registration message and store it in a variable
$registration_message = '';
$is_successful = false; // Flag to check if registration was successful

if (isset($_SESSION['registration_message'])) {
    $registration_message = $_SESSION['registration_message'];
    $is_successful = strpos($registration_message, 'successfully') !== false; // Check if the message indicates success
    // Clear the message after displaying it
    unset($_SESSION['registration_message']);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursary Application System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div style="margin-bottom:-6%;"><img src="image/cdflogo.png"></div>
            <h1 style="color: rgb(15, 15, 15);margin-left: 10%; font-size: 20px;">
                Kibwezi West Constituency Bursary Application
            </h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="index.php#apply">Apply Now</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Success Message Section -->
    <section id="success-message">
        <div class="container">
       
            <!-- Display the registration message -->
            <?php if (!empty($registration_message)): ?>
    <div class="message <?php echo $is_successful ? 'success' : 'error'; ?>" 
         id="registrationMessage" 
         style="color: <?php echo $is_successful ? 'green' : 'red'; ?>;
                background-color: <?php echo $is_successful ? '#e6ffed' : '#ffe6e6'; ?>;
                border: 2px solid <?php echo $is_successful ? '#28a745' : '#dc3545'; ?>;
                padding: 15px;
                margin-left: 20%;
                font-size: 20px;
                width: 60%;
                border-radius: 8px;
                text-align: center;">
        <?php echo $registration_message; ?>
    </div>
<?php endif; ?>


            <!-- If registration was successful, provide a link to log in -->
            <?php if ($is_successful): ?>
                
                <script>
                    // Redirect to login.php after 10 seconds if registration was successful
                    setTimeout(() => {
                        window.location.href = 'login.php'; // Redirect after 10 seconds
                    }, 2500); // 2500 milliseconds = 2.5 seconds
                </script>
           
            <?php endif; ?>

        </div>
    </section>
    <section id="home">
        <div class="home-content">
            <h2>Welcome to the Kibwezi West Bursary Application Portal</h2>
            <p>Apply for educational bursaries easily and securely through our online portal.</p>
            <a href="index.php#apply" class="btn">Get Started</a>
        </div>
    </section>

    <section class="scrolling-section">
        <div class="scrolling-container">
            <img src="image/kbzwst.jpg" class="section-img" alt="Bursary Program Kibwezi West">
            <img src="image/sect2.png" class="section-img" alt="Bursary Program Kibwezi West">
            <img src="image/sect3.png" class="section-img" alt="Bursary Program Kibwezi West">
            <img src="image/sect4.png" class="section-img" alt="Bursary Program Kibwezi West">
            <!-- Add more images as needed -->
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2 class="center-text">About the Bursary Program</h2>
            <p class="center-text">The Kibwezi West Constituency Bursary program aims to assist students in need of financial aid to further their education.</p>
        </div>
    </section>

    <section id="apply">
        <div class="container">
            <h2 class="center-text">Apply for a Bursary</h2>
            <p class="center-text">Start your application by registering or logging into your account.</p>
            <a href="registration.php" class="btn" style="margin-left:27%;">Register</a>
            <a href="login.php" class="btn" style="margin-left:32%;">Login</a>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <h4 style="font-size:17px;">
                Contact us at: Cell: 0720104432 &nbsp;&nbsp;<br>
                Email: <a href="mailto:cdfkibweziwest@cdf.go.ke"><b>cdfkibweziwest@cdf.go.ke</b></a><br>
                <b>NG-CDF-Kibwezi West Constituency<br>
                Makindu Sub-County Headquarter.<br>
                P.O Box136-90138 Makindu, Kenya</b>
            </h4>
        </div>
        <p>&copy; 2024 Kibwezi West Constituency. All rights reserved.</p>
    </footer>

    <script>
        // JavaScript for smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

       
    </script>
</body>
</html>
