<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'trainer') {
    die("Access denied: Please log in as a trainer.");
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal_trainer";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $street = trim($_POST['street']);
    $postcode = trim($_POST['postcode']);
    $city = trim($_POST['city']);
    $specialization = trim($_POST['specialization']);
    $bio = trim($_POST['bio']);

    // Validate and sanitize inputs
    $name = htmlspecialchars($name);
    $street = htmlspecialchars($street);
    $postcode = htmlspecialchars($postcode);
    $city = htmlspecialchars($city);
    $specialization = htmlspecialchars($specialization);
    $bio = htmlspecialchars($bio);

    // Define upload directories
    $upload_dir = 'uploads/';
    $photo_dir = $upload_dir . 'photos/';
    $cv_dir = $upload_dir . 'cvs/';
    $qualification_dir = $upload_dir . 'qualifications/';

    // Create directories if they don't exist
    if (!is_dir($photo_dir)) {
        mkdir($photo_dir, 0777, true);
    }
    if (!is_dir($cv_dir)) {
        mkdir($cv_dir, 0777, true);
    }
    if (!is_dir($qualification_dir)) {
        mkdir($qualification_dir, 0777, true);
    }

    // Handle profile photo upload
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['photo']['tmp_name']);
        if (in_array($file_type, $allowed_types)) {
            $photo_tmp = $_FILES['photo']['tmp_name'];
            $photo_name = uniqid() . '-' . basename($_FILES['photo']['name']);
            $photo_path = $photo_dir . $photo_name;
            move_uploaded_file($photo_tmp, $photo_path);
        } else {
            die("Invalid photo file type.");
        }
    }

    // Handle CV upload
    $cv_path = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = mime_content_type($_FILES['cv']['tmp_name']);
        if (in_array($file_type, $allowed_types)) {
            $cv_tmp = $_FILES['cv']['tmp_name'];
            $cv_name = uniqid() . '-' . basename($_FILES['cv']['name']);
            $cv_path = $cv_dir . $cv_name;
            move_uploaded_file($cv_tmp, $cv_path);
        } else {
            die("Invalid CV file type.");
        }
    }

    // Handle Qualification upload
    $qualification_path = null;
    if (isset($_FILES['qualification']) && $_FILES['qualification']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = mime_content_type($_FILES['qualification']['tmp_name']);
        if (in_array($file_type, $allowed_types)) {
            $qualification_tmp = $_FILES['qualification']['tmp_name'];
            $qualification_name = uniqid() . '-' . basename($_FILES['qualification']['name']);
            $qualification_path = $qualification_dir . $qualification_name;
            move_uploaded_file($qualification_tmp, $qualification_path);
        } else {
            die("Invalid qualification file type.");
        }
    }

    // Insert trainer details into the correct table (trainer_details)
    $stmt = $conn->prepare("INSERT INTO trainer_details (user_id, name, street, postcode, city, specialization, bio, photo, cv, qualification) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("isssssssss", $user_id, $name, $street, $postcode, $city, $specialization, $bio, $photo_path, $cv_path, $qualification_path);

    if ($stmt->execute()) {
        // Redirect to trainer profile page
        header('Location: trainer_profile.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
