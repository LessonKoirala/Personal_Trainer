<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'trainer') {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal_trainer";

// Enable error reporting for MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT td.name, td.street, td.postcode, td.city, td.specialization, td.bio, td.photo, td.cv, td.qualification, u.email
            FROM trainer_details td
            INNER JOIN users u ON td.user_id = u.id
            WHERE td.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $trainer = $result->fetch_assoc();
        echo json_encode($trainer); // Return data as JSON
    } else {
        echo json_encode(['error' => 'Trainer data not found.']);
    }

    $stmt->close();
    $conn->close();
} catch (mysqli_sql_exception $e) {
    echo json_encode(['error' => "Database Error: " . $e->getMessage()]);
}
?>
