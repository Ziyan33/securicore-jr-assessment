<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Only enable this if you're using HTTPS
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Function to check if user is logged in
function checkLoggedIn() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: /task1-weatherApp/public/index.php");
        exit;
    }
}
