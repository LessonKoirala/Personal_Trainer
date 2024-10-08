<?php
// Include session check to verify if the user is logged in
include('session_check.php');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal_trainer";

// Enable error reporting for MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // SQL query to select data using user_id as the unique identifier
    $sql = "SELECT u.name, td.street, td.postcode, td.city, td.specialization, td.bio, td.photo, td.cv, td.qualification, u.email
            FROM trainer_details td
            INNER JOIN users u ON td.user_id = u.id
            WHERE td.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_SESSION['user_id']); // Use the session user_id directly
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the trainer data if found
    if ($result->num_rows > 0) {
        $trainer = $result->fetch_assoc();
    } else {
        echo "Trainer data not found.";
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} catch (mysqli_sql_exception $e) {
    echo "Database Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Profile - Personal Trainers</title>
    <link rel="stylesheet" href="trainerprofile.css">
</head>
<body>
    <header>
        <a href="home.php">
            <h1>Personal Trainer</h1>
        </a>
        <nav>
            <ul id="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="trainer.html">Trainers</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li>
                    <a href="trainer_profile.php" class="profile-icon">
                        <!-- Profile SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M13.468 12.37C12.758 11.226 11.406 10.5 9.5 10.5c-1.906 0-3.258.726-3.968 1.87C4.524 13.111 4.5 13.76 4.5 14.5h7c0-.74-.024-1.389-.532-2.13z"/>
                            <path fill-rule="evenodd" d="M8 8a3 3 0 100-6 3 3 0 000 6zm4-3a4 4 0 11-8 0 4 4 0 018 0z"/>
                            <path fill-rule="evenodd" d="M8 1a7 7 0 100 14A7 7 0 008 1zM8 0a8 8 0 100 16A8 8 0 008 0z"/>
                        </svg>
                    </a>
                </li>
            </ul>
            <!-- Menu toggle button for mobile view -->
            <div class="menu-toggle" id="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
    <main class="main-body">
        <section class="profile-section">
            <h2>Your Profile</h2>
            <div class="profile-container">
                <div class="profile-picture">
                    <img id="trainer-photo-preview" src="<?php echo htmlspecialchars($trainer['photo']); ?>" alt="Profile Picture">
                    <label for="trainer-photo" class="custom-file-upload">Upload Photo</label>
                    <input type="file" id="trainer-photo">
                </div>
                <div class="profile-details">
                    <h3><?php echo htmlspecialchars($trainer['name']); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($trainer['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($trainer['street']) . ', ' . htmlspecialchars($trainer['postcode']) . ', ' . htmlspecialchars($trainer['city']); ?></p>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($trainer['specialization']); ?></p>
                    <p><strong>Biography:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($trainer['bio'])); ?></p>
                    <p><strong>CV:</strong> <a href="<?php echo htmlspecialchars($trainer['cv']); ?>" download>Download CV</a></p>
                    <p><strong>Qualification:</strong> <a href="<?php echo htmlspecialchars($trainer['qualification']); ?>" download>Download Qualification</a></p>
                    <!-- Option to Edit Profile -->
                    <a href="edit_trainer_profile.php" class="submit-button">Edit Profile</a>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Personal Trainers. All rights reserved.</p>
    </footer>
    <script src="trainerprofile.js"></script> <!-- Link to your JavaScript file -->
</body>
</html>
