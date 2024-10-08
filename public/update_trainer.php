<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'trainer') {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Connect to the database
include('db_connect.php'); // Include your database connection script

// Retrieve form data
$name = $_POST['name'];
$specialization = $_POST['specialization'];
$bio = $_POST['bio'];

// Validate and sanitize inputs
$name = htmlspecialchars(strip_tags($name));
$specialization = htmlspecialchars(strip_tags($specialization));
$bio = htmlspecialchars(strip_tags($bio));

// Handle profile photo upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['photo']['type'], $allowed_types)) {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_name = uniqid() . '-' . basename($_FILES['photo']['name']);
        $photo_path = 'uploads/photos/' . $photo_name;
        move_uploaded_file($photo_tmp, $photo_path);
    } else {
        echo "Invalid photo file type.";
        exit();
    }
} else {
    // Keep existing photo if no new photo is uploaded
    $photo_path = null;
}

// Prepare SQL statement
if ($photo_path) {
    $sql = "UPDATE trainers SET name = ?, specialization = ?, bio = ?, photo = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $name, $specialization, $bio, $photo_path, $user_id);
} else {
    $sql = "UPDATE trainers SET name = ?, specialization = ?, bio = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $name, $specialization, $bio, $user_id);
}

// Execute the statement
if ($stmt->execute()) {
    // Redirect back to profile page with success message
    header('Location: trainerprofile.php?success=1');
} else {
    // Handle error
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
