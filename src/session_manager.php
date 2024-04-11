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
// require 'config.php';
// Debugging output
// echo "<pre>";
// var_dump($_POST['email']);
// var_dump($_POST['password']);
// var_dump(USER_EMAIL);
// var_dump(USER_PASSWORD);
// echo "</pre>";
// exit;

// CSRF token validation
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     die('CSRF token validation failed');
// }
// // Check if email and password fields are set
// if ($_POST['email'] === USER_EMAIL && password_verify($_POST['password'], USER_PASSWORD)) {
//     $_SESSION['loggedin'] = true;
//     header('Location: /task1-weatherApp/templates/main.php');
//     exit;
// } else {
//     header('Location: /task1-weatherApp/templates/login.php?error=invalid_credentials');
//     exit;
// }
