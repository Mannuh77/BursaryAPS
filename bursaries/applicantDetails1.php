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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <script>src=validation.js</script>
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        /* Form Styles */
        form {
            width: 100%;
            max-width: 900px; /* Max width for large screens */
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 2px solid #ccc; /* Border around the form */
            border-radius: 8px; /* Optional, to give the form a rounded edge */
            position: relative;
            z-index: 100; /* Ensure the form is on top */
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form container for larger screens */
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
            padding: 10px;
            position: relative; /* Ensure the form-container has a stacking context */
        }

        .form-group {
            flex: 1 1 calc(33.333% - 20px);
            min-width: 250px;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc; /* Border around each form group */
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select {
            padding: 8px;
            border: 1px solid #ccc; /* Border around input fields */
            border-radius: 5px;
            width: 100%; /* Ensure inputs fill available space */
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
            border: 1px solid #ccc; /* Border around the submit button */
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        /* Next Button */
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
        }

        .next-btn:hover {
            background-color: #0056b3;
        }
        
        /* Added styling for error messages */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        /* Styles for valid/invalid input borders (from your original code) */
        input:invalid {
            border-color: red;
        }
        input:valid {
            border-color: green;
        }

        @media (max-width: 768px) {
            .form-group {
                flex: 1 1 100%; /* Stack items on smaller screens */
            }
            .container{
                width:120%;
            }
        }
        
    </style>
</head>
<body>
    <div class="container">
        <form action="submit_applicant.php" method="POST" onsubmit="return validateForm()">
            <h4>Enter your personal Details</h4>
            <div class="form-container">
                <div class="form-group">
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" placeholder="e.g. Muthoni" required>
                    <span id="surname-error" class="error-message"></span>
                </div>
                
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="e.g. Wanjiru" required>
                    <span id="firstName-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="otherNames">Other Names:</label>
                    <input type="text" id="otherNames" name="otherNames" placeholder="e.g. Nyokabi">
                    <span id="otherNames-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" max="" required>
                    <span id="dob-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <span id="gender-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="idNumber">Birth Cert/ID Number:</label>
                    <input type="text" id="idNumber" name="idNumber" 
                           placeholder="e.g. 12345678" 
                           pattern="[0-9]{8}" 
                           title="8-digit ID number" required>
                    <span id="idNumber-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" 
                           placeholder="e.g. example@domain.com" required>
                    <span id="email-error" class="error-message"></span>
                </div>
                
                <div class="form-group">
                    <label for="postalAddress">Postal Address:</label>
                    <input type="text" id="postalAddress" name="postalAddress" 
                            placeholder="e.g. P.O. Box 123" required>
                    <span id="postalAddress-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="postalCode">Postal Code:</label>
                    <input type="text" id="postalCode" name="postalCode" 
                            placeholder="e.g. 90100" 
                            pattern="[0-9]{5}" 
                            title="5-digit postal code" required>
                    <span id="postalCode-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="subCounty">Sub-County:</label>
                    <input type="text" id="subCounty" name="subCounty" 
                            placeholder="e.g. Makueni" required>
                    <span id="subCounty-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="ward">Ward:</label>
                    <select id="ward" name="ward" required>
                        <option value="">Select Ward</option>
                        <option value="Emali/Mulala">Emali/Mulala</option>
                        <option value="Makindu">Makindu</option>
                        <option value="Kikumbulyu North">Kikumbulyu North</option>
                        <option value="Kikumbulyu South">Kikumbulyu South</option>
                        <option value="Nguumo">Nguumo</option>
                        <option value="Nguu/Masumba">Nguu/Masumba</option>
                    </select>
                    <span id="ward-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" 
                            placeholder="e.g. Kibwezi" required>
                    <span id="location-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="subLocation">Sub-location:</label>
                    <input type="text" id="subLocation" name="subLocation" 
                            placeholder="e.g. Kibwezi East" required>
                    <span id="subLocation-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="village">Village:</label>
                    <input type="text" id="village" name="village" 
                            placeholder="e.g. Mwanyani" required>
                    <span id="village-error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="pollingStation">Polling Station:</label>
                    <input type="text" id="pollingStation" name="pollingStation" 
                            placeholder="e.g. Mwanyani Primary School" required>
                    <span id="pollingStation-error" class="error-message"></span>
                </div>
            </div>
            <button type="submit" class="submit-btn">Save</button>
            
            <h2><a href="#" class="next-btn" onclick="loadContent('institutionDetails.php')">Next > Institution Details</a></h2>
        </form>
        
    </div>
    

   <script>
// Validation configuration - all rules and messages in one place
const validationRules = {
    surname: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Surname is required (letters only)',
        required: true
    },
    firstName: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'First name is required (letters only)',
        required: true
    },
    otherNames: {
        test: value => value.trim() === '' || /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Must contain only letters, spaces, hyphens or apostrophes',
        required: false
    },
    dob: {
        test: value => {
            if (!value) return false;
            const dob = new Date(value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            return age >= 16 && age <= 35;
        },
        message: 'Must be 16-35 years old',
        required: true
    },
    gender: {
        test: value => value !== '',
        message: 'Please select a gender',
        required: true
    },
    idNumber: {
        test: value => /^[0-9]{8,12}$/.test(value),
        message: 'Enter a valid ID number (8-12 digits)',
        required: true
    },
    email: {
        test: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
        message: 'Enter a valid email address',
        required: true
    },
    postalAddress: {
        test: value => value.trim() !== '',
        message: 'Postal address is required',
        required: true
    },
    postalCode: {
        test: value => /^[0-9]{5}$/.test(value),
        message: 'Postal code must be 5 digits',
        required: true
    },
    subCounty: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Sub-county is required (letters only)',
        required: true
    },
    ward: {
        test: value => value !== '',
        message: 'Please select a ward',
        required: true
    },
    location: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Location is required (letters only)',
        required: true
    },
    subLocation: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Sub-location is required (letters only)',
        required: true
    },
    village: {
        test: value => /^[a-zA-Z\s\-']+$/.test(value.trim()),
        message: 'Village is required (letters only)',
        required: true
    },
    pollingStation: {
        test: value => /^[a-zA-Z0-9\s\-',.()]+$/.test(value.trim()),
        message: 'Polling station is required',
        required: true
    }
};

/**
 * Validates a single form field
 * @param {string} fieldId - The ID of the field to validate
 * @returns {boolean} - True if valid, false if invalid
 */
function validateField(fieldId) {
    const input = document.getElementById(fieldId);
    if (!input) return true; // Skip if field doesn't exist
    
    const value = input.value.trim();
    const rule = validationRules[fieldId];
    const errorSpan = document.getElementById(`${fieldId}-error`);
    
    // Skip validation for non-required empty fields
    if (!rule.required && value === '') {
        errorSpan.textContent = '';
        input.style.borderColor = '';
        return true;
    }
    
    // Check if field is valid
    const isValid = rule.test(value);
    
    // Update UI based on validation result
    if (!isValid) {
        errorSpan.textContent = rule.message;
        input.style.borderColor = '#ff4444'; // Red color
        return false;
    }
    
    errorSpan.textContent = '';
    input.style.borderColor = '#00C851'; // Green color
    return true;
}

/**
 * Validates the entire form
 * @returns {boolean} - True if all fields are valid, false otherwise
 */
function validateForm() {
    let isFormValid = true;
    
    // Clear all previous errors first
    document.querySelectorAll('.error-message').forEach(el => {
        el.textContent = '';
    });
    
    // Validate each field
    for (const fieldId in validationRules) {
        if (!validateField(fieldId)) {
            isFormValid = false;
        }
    }
    
    return isFormValid;
}

/**
 * Sets up real-time validation and initial form state
 */
function setupValidation() {
    // Initialize real-time validation for each field
    for (const fieldId in validationRules) {
        const input = document.getElementById(fieldId);
        if (input) {
            // Validate on input change
            input.addEventListener('input', () => validateField(fieldId));
            
            // Validate on blur (when leaving the field)
            input.addEventListener('blur', () => validateField(fieldId));
            
            // Initialize field state
            validateField(fieldId);
        }
    }

    // Set date restrictions for date of birth field
    const dobInput = document.getElementById('dob');
    if (dobInput) {
        const today = new Date();
        dobInput.max = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate())
            .toISOString().split('T')[0];
        dobInput.min = new Date(today.getFullYear() - 35, today.getMonth(), today.getDate())
            .toISOString().split('T')[0];
    }
}

// Initialize validation when the script loads
setupValidation();
</script>


</body>
</html>