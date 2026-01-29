<?php
session_start(); // Start the session at the beginning of your script

// Check if there's a message set in the session
$message = ''; // Initialize the message variable
if (isset($_SESSION['message'])) {
    $message = htmlspecialchars($_SESSION['message']); // Get the message
    unset($_SESSION['message']); // Clear the message after displaying it
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursary Application System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .registration-container {
        width: 34%;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: wheat;
    }

    .registration-container h2 {
        text-align: center;
        color: black;
        margin-bottom: 20px;
    }

    .registration-container label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bolder;
        color: black; /* Set label color to black */
        text-align: center; /* Center align the labels */
    }

    .registration-container input[type="text"],
    .registration-container input[type="email"],
    .registration-container input[type="tel"],
    .registration-container input[type="password"],
    .registration-container select1 { /* Include select for styling */
        width: 90%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .registration-container select{
        width: 93%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .registration-container input[type="submit"] {
        width: 85%;
        padding: 10px;
        background-color: #007BFF;
        color: white;
        margin-left: 5%;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .registration-container input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .registration-container input[type="button"] {
        width: 85%;
        padding: 6px;
        background-color: #28a745; /* Change as needed */
        color: white;
        margin-left: 5%;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px; /* Add spacing above the button */
    }

    .registration-container input[type="button"]:hover {
        background-color: #218838; /* Darker shade for hover effect */
    }

    


    /* Responsive Design */
    @media (max-width: 768px) {
        .registration-container {
            width: 60%;
            padding: 7px;
        }
        .registration-container .ward-select {
        width: 100%; /* Ensures it takes full width */
    }
        .registration-container h2 {
            font-size: 1.5em;
        }

        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="tel"],
        .registration-container input[type="password"]{
                    padding: 6px;
        
        }

        .registration-container input[type="submit"],
        .registration-container input[type="button"] {
            padding: 8px;
            font-size: 1em;
        }
    }

    @media (max-width: 480px) {
        .registration-container {
            width: 75%;
            padding: 10px;
        }
       .registration-container select {
        width: 55%; /* Default or auto width */
        padding: 5px; /* Reset padding */
        margin-left: 5%;
        font-weight: bolder;
        margin-bottom: 15px; /* Keep bottom margin */
        border: none; /* Reset border */
        border-radius: 0; /* Reset border-radius */
    }

        .registration-container h2 {
            font-size: 1.2em;
        }

        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="tel"],
        .registration-container input[type="password"]{ /* Ensure padding consistency */
            padding: 6px;
            
        }

        .registration-container input[type="submit"],
        .registration-container input[type="button"] {
            padding: 6px;
            font-size: 0.9em;
        }
    }

    .error { color: red; }
</style>
<script>
        function resetForm() {
            document.getElementById("registrationForm").reset();
        }
    </script>
<body>
    <header>
        <div class="container">
            <img src="image/cdflogo.png" alt="CDF Logo" style="margin-bottom: -6%;">
            <h1 style="color: rgb(15, 15, 15); margin-left: 10%; font-size: 20px;">Kibwezi West Constituency Bursary Application</h1>
                <nav>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="#about">About</a></li> <!-- Updated to link to the about section -->
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </nav>

        </div>
    </header>

    <main>
    <section> <!-- Registration Form -->
    <div class="registration-container">
        <h2>Student Registration</h2>
<form id="registrationForm" action="register.php" method="post" autocomplete="on">
    <label for="first-name">First Name:</label>
    <input type="text" id="first-name" name="first_name" required>
    <span class="error" id="firstNameError"></span><br>

    <label for="middle-name">Middle Name:</label>
    <input type="text" id="middle-name" name="middle_name">
    <span class="error" id="middleNameError"></span><br>

    <label for="last-name">Last Name:</label>
    <input type="text" id="last-name" name="last_name" required>
    <span class="error" id="lastNameError"></span><br>

    <label for="id-number">ID Number/Birth Certificate Number:</label>
    <input type="text" id="id-number" name="id_number" required>
    <span class="error" id="idNumberError"></span><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required autocomplete="username">
    <span class="error" id="emailError"></span><br>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required>
    <span class="error" id="phoneError"></span><br>

    <label for="ward">Ward:</label>
    <select id="ward" name="ward" required onchange="updatePollingStations()">
        <option value="">-- Select Ward First --</option>
        <option value="Makindu">Makindu</option>
        <option value="Nguumo">Nguumo</option>
        <option value="Kikumbulyu North">Kikumbulyu North</option>
        <option value="Kikumbulyu South">Kikumbulyu South</option>
        <option value="Nguu/Masumba">Nguu/Masumba</option>
        <option value="Emali/Mulala">Emali/Mulala</option>
    </select>
    <span class="error" id="wardError"></span><br>

   <label for="pollingstation">Polling Station:</label>
    <select id="pollingstation" name="pollingstation" required disabled>
        <option value="">-- Select Ward First --</option>
    </select>
    <span class="error" id="pollingstationError"></span><br>    

    <label for="password">Password:</label>
    <div style="display: flex; align-items: center;">
        <input type="password" id="password" name="password" required autocomplete="new-password">
        <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password', this)" style="cursor: pointer; margin-left: 10px;"></i>
    </div>
    <span class="error" id="passwordError"></span><br>

    <label for="confirm-password">Confirm Password:</label>
    <div style="display: flex; align-items: center;">
        <input type="password" id="confirm-password" name="confirm_password" required autocomplete="new-password">
        <i class="fas fa-eye" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirm-password', this)" style="cursor: pointer; margin-left: 10px;"></i>
    </div>
    <span class="error" id="confirmPasswordError"></span><br>

    <input type="submit" value="Register">
    <p style="margin-left:20%;">If registered. Click Login below</p>
    <input type="button" value="Login" onclick="window.location.href='login.php'">
</form>

<!-- Include the wards.js script -->
<script src="wards.js"></script>
</section>

        <section id="about">
    <div class="container">
    <h2 class="center-text">About the Bursary Program</h2>
    <p class="center-text">The Kibwezi West Constituency Bursary program aims to assist students in need of financial aid to further their education.</p></p>
        <!-- Add more information as needed -->
    </div>
</section>

        <footer id="contact">
            <div class="container">
                <p>Contact us at: Cell: 0720104432 &nbsp &nbsp <br>Email: <b><a href="mailto:cdfkibweziwest@cdf.go.ke">cdfkibweziwest@cdf.go.ke</b> <br> <b>
                    NG-CDF-Kibwezi West Constituency<br>
                    Makindu Sub-County Headquarter.<br>
                    P.O Box 136-90138
                    Makindu, Kenya
                </b></a></p>
            </div>
            <p>&copy; 2024 Kibwezi West Constituency. All rights reserved.</p>
        </footer>

        <script>
        function togglePassword(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;

            // Change the icon based on the visibility
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
        </script>

        <script>
            // JavaScript code for additional interactivity or functionality
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Validation functions
            function validateFirstName() {
                const firstName = document.getElementById('first-name').value;
                const firstNameError = document.getElementById('firstNameError');
                if (!/^[a-zA-Z]+$/.test(firstName)) {
                    firstNameError.textContent = 'First Name can only contain letters.';
                } else {
                    firstNameError.textContent = '';
                }
            }

            function validateLastName() {
                const lastName = document.getElementById('last-name').value;
                const lastNameError = document.getElementById('lastNameError');
                if (!/^[a-zA-Z]+$/.test(lastName)) {
                    lastNameError.textContent = 'Last Name can only contain letters.';
                } else {
                    lastNameError.textContent = '';
                }
            }

            function validateWard() {
                const ward = document.getElementById('ward').value;
                const wardError = document.getElementById('wardError');
                if (ward === "") {
                    wardError.textContent = 'Please select a ward.';
                } else {
                    wardError.textContent = '';
                }
            }

            function validateIDNumber() {
                const idNumber = document.getElementById('id-number').value;
                const idNumberError = document.getElementById('idNumberError');
                // Adjust validation pattern as needed
                if (!/^\d{6,10}$/.test(idNumber)) { // Example: ID number should be 6 to 10 digits
                    idNumberError.textContent = 'ID Number must be between 6 to 10 digits.';
                } else {
                    idNumberError.textContent = '';
                }
            }

            function validatePhone() {
                const phone = document.getElementById('phone').value;
                const phoneError = document.getElementById('phoneError');
                if (!/^\d{10}$/.test(phone)) {
                    phoneError.textContent = 'Phone Number must be exactly 10 digits.';
                } else {
                    phoneError.textContent = '';
                }
            }

            function validateEmail() {
                const email = document.getElementById('email').value;
                const emailError = document.getElementById('emailError');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                } else {
                    emailError.textContent = '';
                }
            }
            function togglePassword(fieldId) {
                const passwordField = document.getElementById(fieldId);
                const type = passwordField.type === "password" ? "text" : "password";
                passwordField.type = type;
                // Optionally, change the button text
                const button = event.target; // Get the button that was clicked
                button.textContent = type === "password" ? "Show" : "Hide";
            }

            function validatePassword() {
                const password = document.getElementById('password').value;
                const passwordError = document.getElementById('passwordError');
                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
                    passwordError.textContent = 'Password must be at least 8 characters long, contain upper and lower case letters, a number, and a special symbol.';
                } else {
                    passwordError.textContent = '';
                }
            }

            function validateConfirmPassword() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm-password').value;
                const confirmPasswordError = document.getElementById('confirmPasswordError');
                if (password !== confirmPassword) {
                    confirmPasswordError.textContent = 'Passwords do not match.';
                } else {
                    confirmPasswordError.textContent = '';
                }
            }

            document.getElementById('first-name').addEventListener('input', validateFirstName);
            document.getElementById('last-name').addEventListener('input', validateLastName);
            document.getElementById('ward').addEventListener('change', validateWard);
            document.getElementById('id-number').addEventListener('input', validateIDNumber);
            document.getElementById('phone').addEventListener('input', validatePhone);
            document.getElementById('password').addEventListener('input', validatePassword);
            document.getElementById('confirm-password').addEventListener('input', validateConfirmPassword);

            document.getElementById('registrationForm').addEventListener('submit', function(event) {
                validateFirstName();
                validateLastName();
                validateWard();
                validateIDNumber();
                validatePhone();
                validateEmail();
                validatePassword();
                validateConfirmPassword();

                const errors = document.querySelectorAll('.error');
                const valid = Array.from(errors).every(error => error.textContent === '');

                if (!valid) {
                    event.preventDefault();
                }
            });
        </script>

    </main>
</body>
</html>
