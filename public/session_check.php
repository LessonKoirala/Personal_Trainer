<?php
session_start();

// Check if the user is not logged in or not a trainer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'trainer') {
    header('Location: login.html');
    exit();
}
?>
