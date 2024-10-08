<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Query to fetch trainer details
$sql = "SELECT u.name, u.email, u.user_type, t.specialization, t.bio, t.photo, t.cv 
        FROM users u 
        JOIN trainer_details t ON u.id = t.user_id 
        WHERE u.user_type = 'trainer'";
$result = $conn->query($sql);

$trainers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode(['trainers' => $trainers]);

$conn->close();
?>
