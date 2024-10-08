<?php
session_start();

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal_trainer";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists and is a trainer
    $sql = "SELECT id, password, user_type FROM users WHERE email = ? AND user_type = 'trainer'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) { // Assumes passwords are hashed
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // Redirect to trainer profile page
            header('Location: trainer_profile.php');
            exit();
        } else {
            // Invalid password
            echo "Invalid email or password.";
        }
    } else {
        // User not found or not a trainer
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>
