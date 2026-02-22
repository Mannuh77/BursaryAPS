
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
         <div style="margin-bottom:-6%;"><img src="image/cdflogo.png"> </div>   
        

            <h1  style="color: rgb(15, 15, 15);margin-left: 10%; font-size: 25px;"> Kibwezi West Constituency Bursary Application</h1>
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
            <a href="registration.php" class="btn" style="margin-left:27%;" >Register</a>
            <a href="login.php" class="btn" style="margin-left:32%;" >Login</a>
        </div>
    </section>
    
    <footer id="contact">
        <div class="container">
            
            <h4 style="font-size:17px;">Contact us at: Cell: 0720104432 &nbsp &nbsp <br>Email: <b><a href="cdfkibweziwest@cdf.go.ke ">cdfkibweziwest@cdf.go.ke</b> <br> <b>
                NG-CDF-Kibwezi West Constituency<br>
                Makindu Sub-County Headquarter.<br>
                P.O Box136-90138
                Makindu, Kenya 

            </b></a></h4>
        </div>
        <p>&copy;<?php echo date("Y"); ?> Kibwezi West Constituency. All rights reserved.</p>
    </footer>

    <script >
        // JavaScript code can be used for additional interactivity or functionality
// Example: Adding smooth scroll to anchor links

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
