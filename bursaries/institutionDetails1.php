<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Institution Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Form Styles */
        form {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            position: relative;
            z-index: 100;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
            padding: 10px;
            position: relative;
        }

        .form-group {
            flex: 1 1 calc(33.333% - 20px);
            min-width: 250px;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            border: 1px solid #ccc;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .next-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
        }

        .next-btn:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        input:invalid, select:invalid {
            border-color: #ff4444;
        }

        input:valid, select:valid {
            border-color: #00C851;
        }

        @media (max-width: 768px) {
            .form-group {
                flex: 1 1 100%;
            }
            .container {
                width: 120%;
            }
            .next-btn {
                padding: 12px 15px;
                font-size: 18px;
                display: block;
                margin-top: 20px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="submit_institution_details.php" method="POST" onsubmit="return validateForm()">
            <h4>Enter Your Institutional Details</h4>
            <div class="form-container">
                <div class="form-group">
                    <label for="institutionName">Institution Name:</label>
                    <input type="text" id="institutionName" name="institutionName" 
                           pattern="[A-Za-z\s\-&',.()]{5,100}" 
                           title="Institution name (5-100 characters)" required>
                    <span id="institutionName-error" class="error-message"></span>
                </div>
                
                <div class="form-group">
                    <label for="course">Course Name:</label>
                    <input type="text" id="course" name="course" 
                           pattern="[A-Za-z\s\-&',.()]{5,100}" 
                           title="Course name (5-100 characters)" required>
                    <span id="course-error" class="error-message"></span>
                </div>

                <div class="form-group">
                <label for="registrationNumber">Registration Number:</label>
                <input type="text" id="registrationNumber" name="registrationNumber" 
                    pattern="[A-Za-z0-9/\-]{1,20}" 
                    title="Registration number (1-20 characters, digits, '/', or '-')" required>
                <span id="registrationNumber-error" class="error-message"></span>
            </div>


                <div class="form-group">
                    <label for="yearOfStudy">Year of Study:</label>
                    <select id="yearOfStudy" name="yearOfStudy" required>
                        <option value="" disabled selected>Select Year of Study</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                        <option value="5">Year 5</option>
                        <option value="6">Year 6</option>
                    </select>
                    <span id="yearOfStudy-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="institutionAddress">Institution Address:</label>
                    <input type="text" id="institutionAddress" name="institutionAddress" 
                           minlength="10" maxlength="200" required>
                    <span id="institutionAddress-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="institutionPhone">Institution Phone:</label>
                    <input type="tel" id="institutionPhone" name="institutionPhone" 
                           pattern="[0-9\s\-+]{10,15}" 
                           title="Valid phone number (10-15 digits)" required>
                    <span id="institutionPhone-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="institutionEmail">Institution Email:</label>
                    <input type="email" id="institutionEmail" name="institutionEmail" 
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    <span id="institutionEmail-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="dateOfAdmission">Date of Admission:</label>
                    <input type="date" id="dateOfAdmission" name="dateOfAdmission" required>
                    <span id="dateOfAdmission-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="courseDuration">Course Duration:</label>
                    <input type="text" id="courseDuration" name="courseDuration" required>
                    <span id="courseDuration-error" class="error-message"></span>
                </div>

            </div>
            <button type="submit" class="submit-btn">Save</button>
            <h2><a href="#" class="next-btn" onclick="loadContent('attachments.php')">Next > Attachments</a></h2>
        </form>
    </div>

    <script>
        // Validation configuration (removed registrationNumber, institutionAddress, courseDuration)
        const validationRules = {
            institutionName: {
                test: value => /^[A-Za-z\s\-&',.()]{5,100}$/.test(value.trim()),
                message: 'Institution name (5-100 characters)',
                required: true
            },
            course: {
                test: value => /^[A-Za-z\s\-&',.()]{5,100}$/.test(value.trim()),
                message: 'Course name (5-100 characters)',
                required: true
            },
            yearOfStudy: {
                test: value => value !== '',
                message: 'Please select year of study',
                required: true
            },
            institutionPhone: {
                test: value => /^[0-9\s\-+]{10,15}$/.test(value.trim()),
                message: 'Valid phone number (10-15 digits)',
                required: true
            },
            institutionEmail: {
                test: value => /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(value.trim()),
                message: 'Enter a valid email address',
                required: true
            },
            dateOfAdmission: {
                test: value => {
                    if (!value) return false;
                    const admissionDate = new Date(value);
                    const currentDate = new Date();
                    return admissionDate <= currentDate;
                },
                message: 'Admission date cannot be in the future',
                required: true
            }
        };

        /**
         * Validates a single form field
         */
        function validateField(fieldId) {
            const input = document.getElementById(fieldId);
            if (!input) return true;
            
            const value = input.value.trim();
            const rule = validationRules[fieldId];
            const errorSpan = document.getElementById(`${fieldId}-error`);
            
            if (!rule) {
                // No JS validation for this field, clear error and border colors
                errorSpan.textContent = '';
                input.style.borderColor = '';
                return true;
            }
            
            if (!rule.required && value === '') {
                errorSpan.textContent = '';
                input.style.borderColor = '';
                return true;
            }
            
            const isValid = rule.test(value);
            
            if (!isValid) {
                errorSpan.textContent = rule.message;
                input.style.borderColor = '#ff4444';
                return false;
            }
            
            errorSpan.textContent = '';
            input.style.borderColor = '#00C851';
            return true;
        }

        /**
         * Validates the entire form
         */
        function validateForm() {
            let isFormValid = true;
            
            document.querySelectorAll('.error-message').forEach(el => {
                el.textContent = '';
            });
            
            for (const fieldId in validationRules) {
                if (!validateField(fieldId)) {
                    isFormValid = false;
                }
            }

            return isFormValid;
        }

        // Real-time validation event listeners
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', e => {
                validateField(e.target.id);
            });
            input.addEventListener('blur', e => {
                validateField(e.target.id);
            });
        });

        /**
         * Example function for Next button (load content dynamically)
         */
        function loadContent(url) {
            // For example, ajax call to load 'attachments.php' content dynamically
            // Here we just simulate with an alert or you can implement real AJAX.
            alert('Next page would load: ' + url);
            // Prevent default anchor navigation
            return false;
        }
    </script>
</body>
</html>
