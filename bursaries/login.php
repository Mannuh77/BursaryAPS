<?php
// Start session at the top before any output
session_start();

// Database configuration
$db_username = 'root';
$db_password = '';
$db_name = 'kibweziwest';
$db_host = 'localhost';

// Create a new MySQLi connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize message variable
$message = '';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid request. Please try again.";
    } else {
        // Sanitize input
        $email = $mysqli->real_escape_string(trim($_POST['email']));
        $password = $mysqli->real_escape_string(trim($_POST['password']));

        // Prepare SQL
        $sql = "SELECT * FROM applicants WHERE email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id']; // Assumes 'id' field exists
                    header("Location: dashboard.php");
                    exit();
                }
            }

            // Generic error message for security
            $message = "Invalid email or password.";
            $stmt->close();
        } else {
            $message = "Server error. Please try again later.";
        }
    }
}

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursary Application System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* (Your existing CSS styles remain unchanged) */
        .login-container {
            width: 34%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: wheat;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }
        .login-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bolder;
            color: black;
            text-align: center;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .login-container input[type="submit"] {
            width: 85%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            margin-left: 5%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            width: 89%;
            text-align: center;
        }
        @media (max-width: 768px) {
            .login-container {
                width: 60%;
                padding: 7px;
            }
        }
        @media (max-width: 480px) {
            .login-container {
                width: 75%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <img src="image/cdflogo.png" alt="CDF Logo" style="margin-bottom: -6%;">
            <h1 style="color: rgb(15, 15, 15); margin-left: 10%; font-size: 20px;">Kibwezi West Constituency Bursary Application</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#about">About</a></li> 
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
    <section>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($message): ?>
            <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <div style="display: flex; align-items: center;">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword" onclick="togglePassword('password', this)" style="cursor: pointer; margin-left: 10px;"></i>
            </div>

            <!-- CSRF token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <p style="margin-left:25%;"> Not registered? <a href="registration.php" class="btn">Register</a></p>
            <input type="submit" value="Login">
        </form>
    </div>
    </section>

    <script>
    function togglePassword(fieldId, icon) {
        const passwordField = document.getElementById(fieldId);
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Toggle icon style
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    }
    </script>

    <section id="about">
        <div class="container">
            <h2 class="center-text">About the Bursary Program</h2>
            <p class="center-text">The Kibwezi West Constituency Bursary program aims to assist students in need of financial aid to further their education.</p>
        </div>
    </section>
    </main>

    <footer id="contact">
        <div class="container">
            <p>Contact us at: Cell: 0720104432 <br>Email: <b><a href="mailto:cdfkibweziwest@cdf.go.ke">cdfkibweziwest@cdf.go.ke</a></b><br>
                <b>NG-CDF-Kibwezi West Constituency<br>
                Makindu Sub-County Headquarter.<br>
                P.O Box 136-90138 Makindu, Kenya</b></p>
        </div>
        <p>&copy; 2024 Kibwezi West Constituency. All rights reserved.</p>
    </footer>
</body>
</html>
