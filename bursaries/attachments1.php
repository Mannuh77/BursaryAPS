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
    <title>Upload Attachments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
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
        }

        .form-group {
            flex: 1 1 calc(50% - 20px);
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

        input[type="file"] {
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
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            .form-group {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<form action="submit_attachments.php" method="POST" enctype="multipart/form-data">
    <h4>Upload Your Attachments</h4>
    <div class="form-container">
        <div class="form-group">
            <label for="birthCertificate">Birth Certificate/ID:</label>
            <input type="file" name="birthCertificate" required>
        </div>
        <div class="form-group">
            <label for="admissionLetter">Admission Letter/School ID:</label>
            <input type="file" name="admissionLetter" required>
        </div>
        <div class="form-group">
            <label for="feesStructure">Fees Structure:</label>
            <input type="file" name="feesStructure" required>
        </div>
        <div class="form-group">
            <label for="faithLetter">Letter from Faith Leader/Chief (Optional):</label>
            <input type="file" name="faithLetter">
        </div>
        <div class="form-group">
            <label for="otherDocuments">Other Supporting Documents (Optional):</label>
            <input type="file" name="otherDocuments[]" multiple>
            <small class="form-text text-muted">You can upload multiple files (e.g., PDF, DOCX).</small>
        </div>
    </div>
    <button type="submit" class="submit-btn">Upload</button>
    <h2><a href="#" class="next-btn" onclick="loadContent('apply.php')"> Next >Apply</a></h2>
</form>

</body>
</html>
