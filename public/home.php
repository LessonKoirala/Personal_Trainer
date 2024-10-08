<?php include('session_check.php'); // Ensure user is logged in ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Trainer</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=your_api_key"></script> <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
</head>
<body> 
    <header>
        <a href="home.php">
            <h1>Personal Trainer</h1>
        </a>
        <nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="trainer.html">Trainers</a></li> <!-- This points to the public trainer list -->
        <li><a href="trainer_profile.php">Profile</a></li> <!-- Protected page for logged-in users -->
        <li><a href="logout.php">Logout</a></li> <!-- Logout option for logged-in users -->
    </ul>
</nav>

    </header>

    <!-- New Section with Big Text and Gradient Background + Image -->
    <div class="main-body">
        <div class="content">
            <h2>Your Journey to Fitness Starts Here</h2>
            <img src="photo.jpg" alt="Fitness Image" class="main-image">
        </div>
    </div>

    <!-- Quote Section -->
    <div class="quote">
        <p>"If you don’t find the time,<br> if you don’t do the work,<br> you don’t get the results." <br>– Arnold Schwarzenegger</p>
    </div>
    <!-- Types of Training Section -->
    <div class="training-types">
        <h3>Train Your Way</h3>
        <!-- Training Grid -->
        <div class="training-grid">
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
            <div class="training-card">
                <div class="overlay">lorem</div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Personal Trainers. All rights reserved.</p>
        <p>Follow us on: 
            <a href="#" class="social-link">Facebook</a> | 
            <a href="#" class="social-link">Twitter</a> | 
            <a href="#" class="social-link">Instagram</a>
        </p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
