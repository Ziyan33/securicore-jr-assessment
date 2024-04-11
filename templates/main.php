<?php
$pageTitle = "Main Page"; // Set a variable for the title to use in header.php
include '../templates/header.php';
include_once '../src/session_manager.php';
checkLoggedIn();  // Check if the user is logged in

// Prevent this page from being cached by the browser.
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

?>


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
<script src="/task1-weatherApp/public/js/main.js"></script>  <!-- Link to external JS file -->

<?php include '../templates/footer.php'; // Include the footer template ?>
