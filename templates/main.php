<?php
session_start();

// Prevent this page from being cached by the browser.
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Check if the user is logged in, otherwise redirect to login page.
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /task1-weatherApp/public/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<button onclick="logout();">Logout</button>
<script>
function logout() {
    // Correct the path if necessary to ensure it points to your actual logout script location
    document.location = '/task1-weatherApp/src/logout.php';
}
</script>
<div>
    <input type="text" id="lat" placeholder="Latitude">
    <input type="text" id="lon" placeholder="Longitude">
    <button onclick="fetchWeather();">Fetch Weather</button>
    <div id="weatherResult"></div>
</div>
<script>
function validateInput() {
    var lat = parseFloat(document.getElementById('lat').value);
    var lon = parseFloat(document.getElementById('lon').value);
    if (isNaN(lat) || isNaN(lon) || lat < -90 || lat > 90 || lon < -180 || lon > 180) {
        alert("Please enter valid latitude and longitude values.");
        return false;
    }
    return true;
}

function fetchWeather() {
    if (!validateInput()) {
        return; // Stop the function if validation fails
    }
    var lat = $('#lat').val();
    var lon = $('#lon').val();
    $.ajax({
        url: '/task1-weatherApp/src/weather.php',
        type: 'POST',
        data: {
            lat: lat,
            lon: lon
        },
        success: function(response) {
            $('#weatherResult').html(response);
        }
    });
}
</script>
</body>
</html>