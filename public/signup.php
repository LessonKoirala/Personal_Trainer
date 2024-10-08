<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session at the top of the file
session_start();

// Database connection settings
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "personal_trainer"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and sanitize inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_type = $_POST['userType'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Password matching validation
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists using prepared statement
    $stmt_check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Email already exists.";
    } else {
        // Insert user data into the database using prepared statement
        $stmt_insert = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("ssss", $name, $email, $hashed_password, $user_type);

        if ($stmt_insert->execute()) {
            // Set session variables after successful insertion
            $_SESSION['user_id'] = $stmt_insert->insert_id; // Store the user ID in the session
            $_SESSION['user_type'] = $user_type;

            if ($user_type === 'trainer') {
                // Redirect to detail.html for trainers after successful signup
                header('Location: detail.html');
                exit();
            } else {
                // Redirect to client dashboard or appropriate page
                header('Location: client_dashboard.php');
                exit();
            }
        } else {
            echo "Error: " . $stmt_insert->error;
        }
        $stmt_insert->close(); // Close the statement after execution
    }

    $stmt_check->close(); // Close the statement after execution
}

// Close the database connection
$conn->close();
?>
