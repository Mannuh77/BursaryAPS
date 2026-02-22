<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Kibwezi West - Mission and Objectives</title>
  
</head>
<style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
    color: #0f0f0f;
    background-color: #f4f4f4;
}

.container {
    width: 90%;
    margin: auto;
    overflow: hidden;
}

/* Header Styling */
header {
    background: linear-gradient(to right, #eaf0f1, #1e5735); /* Gradient background for the header */
    color: #fff; /* Text color */
    padding: 15px 0; /* Padding around the header */
    border-bottom: 3px solid #77ab59; /* Bottom border */
    position: relative; /* Relative positioning for menu icon */
}

/* Container Styling */
header .container {
    display: flex; /* Use Flexbox for alignment */
    justify-content: space-between; /* Space between the title and the navigation */
    align-items: center; /* Center items vertically */
    width: 90%; /* Width of the container */
    max-width: 1200px; /* Maximum width */
    margin: 0 auto; /* Center the container */
}

/* Menu Icon Styling */
.menu-icon {
    display: none; /* Hide by default */
    font-size: 30px; /* Icon size */
    cursor: pointer; /* Pointer cursor on hover */
}
header h1 {
    color: #0f0f0f;
    font-style: italic;
    font-weight: bolder;
    font-size: 40px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}

/* Navigation Menu Styling */
header nav {
    display: flex; /* Use Flexbox for alignment */
}

header ul {
    list-style: none; /* Remove bullet points */
    padding: 0; /* Remove default padding */
    margin: 0; /* Remove default margin */
    display: flex; /* Arrange list items horizontally */
}

header li {
    margin: 0 10px; /* Space between menu items */
}

header a {
    color: #fff; /* White text color for links */
    text-decoration: none; /* Remove underline */
    font-weight: bold; /* Bold text */
    text-transform: uppercase; /* Uppercase text */
    transition: color 0.3s ease; /* Smooth color transition on hover */
}

header a:hover {
    color: #77ab59; /* Change color on hover */
}

/* Responsive Styling */
@media (max-width: 768px) {
    header .container {
        flex-direction: column; /* Stack items vertically on smaller screens */
        align-items: flex-start; /* Align items to the start */
    }

    header h1 {
        font-size: 20px; /* Slightly smaller font size for smaller screens */
        margin-bottom: 10px; /* Add space below the title */

    }

    .menu-icon {
        display: block; /* Show menu icon on small screens */
    }

    .nav-menu {
        display: none; /* Hide menu by default on small screens */
        width: 100%; /* Full width */
        background: #1e5735; /* Background color for menu */
        position: absolute; /* Absolute positioning for menu */
        top: 60px; /* Adjust based on header height */
        left: 0;
        padding: 20px; /* Padding around menu items */
    }

    .nav-menu ul {
        flex-direction: column; /* Stack menu items vertically */
    }

    .nav-menu li {
        margin: 10px 0; /* Space between menu items */
    }

    .nav-menu.active {
        display: flex; /* Show menu when active */
    }
}

/* Hide menu items on small screens */
@media (max-width: 480px) {
    header h1 {
        font-size: 18px; /* Smaller font size for very small screens */
    }

    header a {
        font-size: 14px; /* Smaller font size for links */
    }
}


/* Home Section */
.home-content {
    text-align: center;
    padding: 50px 0;
    background: #a3d3db;
}

.home-content h2 {
    margin-bottom: 20px;
}

.home-content p {
    margin-bottom: 30px;
}

/* About, Mission, and Objectives Sections */
section {
    padding: 50px 0;
    background: wheat;
    border-bottom: 1px solid #ddd;
}

section h2 {
    text-align: center;
    margin-bottom: 30px;
}

section p, section ul {
    text-align: center;
    max-width: 800px;
    margin: auto;
    line-height: 1.8;
}

section ul li {
    margin-bottom: 15px;
}

/* Footer */
footer {
    background: #34495e;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

footer p {
    margin: 5px 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    header ul {
        flex-direction: column;
    }

    header li {
        padding: 10px 0;
    }

    section {
        padding: 30px 0;
    }
}

@media (max-width: 480px) {
    .home-content h2 {
        font-size: 24px;
    }

    .home-content p {
        font-size: 16px;
    }

    a, button {
        padding: 8px 15px;
        font-size: 14px;
    }
}
/* Section Styling */
.mp {
    display: flex; /* Center-align contents with Flexbox */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    padding: 20px; /* Add some padding around the section */
    background: linear-gradient(to right, #b240bd, #8f0a94);/* Optional: background color for the section */
}

/* Container Styling */
.mp-container {
    text-align: center; /* Center-align text inside the container */
    max-width: 800px; /* Limit the width of the content */
    width: 100%;
}

/* Heading Styling */
.mp h1 {
    font-size: 28px; /* Adjust font size for main heading */
    margin: 10px 0; /* Margin above and below heading */
    color: #080808; /* Text color */
   
}

.mp h2 {
       font-size: 34px; /* Adjust font size for main heading */
    margin: 10px 0; /* Margin above and below heading */
    color: #080808; /* Text color */
    font-weight: bolder;
   
}

/* Image Styling */
.mp img {
    max-width: 100%; /* Make the image responsive */
    height: auto; /* Maintain aspect ratio */
    border-radius: 8px; /* Optional: rounded corners for the image */
    margin: 20px 0; /* Margin above and below image */
}

/* Paragraph Styling */
.mp p {
    font-size: 16px; /* Adjust font size for the paragraph */
    color: #666; /* Text color */
    line-height: 1.6; /* Increase line height for readability */
    margin: 10px 0; /* Margin above and below paragraph */
}

/* Responsive Styling */
@media (max-width: 768px) {
    .mp h1 {
        font-size: 20px; /* Smaller font size for smaller screens */
    }

    .mp h2 {
        font-size: 18px; /* Smaller font size for smaller screens */
    }

    .mp p {
        font-size: 14px; /* Smaller font size for smaller screens */
    }
}


</style>
<body>
    <header>
        <div class="container">
            <h1>About Kibwezi West</h1>
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="home.php#mission">Mission</a></li>
                    <li><a href="home.php#objectives">Objectives</a></li>
                    <li><a href="index.php#apply">Apply Now</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <h2 style="color: rgb(7, 7, 7)">About Kibwezi West</h2>
            <b style="font-size:18px; font-weight: bold;"><p>Kibwezi West Constituency is one of the constituencies in Kenya that is dedicated to the development and welfare of its residents. The bursary program is one of the initiatives aimed at supporting education and ensuring that every child has access to quality education.</p>
        </div>
    </section>
    
    <section class="mp">
        <div class="mp-container">
            <h2 >Hon. Eckomas Mwengi Mutuse</h2>
            <img src="image/mp.png" alt="Hon. Eckomas Mwengi Mutuse">
            <h1><b>Member of Parliament, Kibwezi West Constituency.</b></h1>
            <p style="color: #000;font-weight: bolder;font-size: 19px;">Elected 2022, On Maendeleo Chap Chap Party</p>.</p>
        </div>
    </section>
    

    <!-- Mission Section -->
    <section id="mission">
        <div class="container">
            <h2>Our Mission</h2>
            <p>Our mission is to empower the youth of Kibwezi West through education by providing financial support to deserving students, enabling them to pursue their academic dreams and contribute positively to the community.</p>
        </div>
    </section>

    <!-- Objectives Section -->
    <section id="objectives">
        <div class="container">
            <h2>Our Objectives</h2>
            <ul>
                <li>To provide financial assistance to students from low-income families.</li>
                <li>To reduce the dropout rate by ensuring that students have the necessary resources to complete their education.</li>
                <li>To support the development of a skilled and educated workforce in Kibwezi West.</li>
                <li>To promote equal opportunities in education for all students, regardless of their background.</li>
            </ul>
        </div>
    </section>

    <footer>
        <div>
 
            <p>Contact us at: Cell: 0720104432 <br> Email:<a href="mailto:cdfkibweziwest@cdf.go.ke " style="color: #f7f5f5;">  cdfkibweziwest@cdf.go.ke</a><br>
                NG-CDF-Kibwezi West Constituency<br>
                Makindu Sub-County Headquarter.
                P.O Box136-90138
                Makindu, Kenya </p>
        </div>
        <p>&copy; 2024 Kibwezi West Constituency. All rights reserved.</p>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
    </script>
    <script>
    function toggleMenu() {
        const menu = document.querySelector('.nav-menu');
        menu.classList.toggle('active');
    }
</script>

</body>
</html>
