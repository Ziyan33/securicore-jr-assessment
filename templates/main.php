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


<!-- <button onclick="logout();">Logout</button> -->

<!-- <div>
    <input type="text" id="lat" placeholder="Latitude">
    <input type="text" id="lon" placeholder="Longitude">
    <button onclick="fetchWeather();">Fetch Weather</button>
    <div id="weatherResult"></div>
</div> --><br/>
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <form id="weatherForm" class="text-center">
                <h1 class="h3 mb-3 fw-normal">Enter Coordinates</h1>
                <input type="text" id="lat" class="form-control" placeholder="Latitude" required>
                <input type="text" id="lon" class="form-control mt-2" placeholder="Longitude" required>
                <p>latitude range:-90 to 90  <br/> longitude range:-180 to 180 </p>
                <button class="btn btn-lg btn-primary btn-block mt-4" type="button" onclick="fetchWeather();">Fetch Weather</button>
            </form>
            <div class="card weather-card" id="weatherCard">
                <div class="card-body">
                    <h5 class="card-title" id="city">City Name</h5>
                    <p class="card-text"><i class="fas fa-thermometer-half icon"></i> <span id="temperature">--°C</span></p>
                    <p class="card-text"><i class="fas fa-cloud icon"></i> <span id="weather-description">Weather Description</span></p>
                    <p class="card-text"><i class="fas fa-clock icon"></i> <span id="recorded_at">Recorded At</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="table-wrapper">

        <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Weather <b>Details</b></h2></div>
                    </div>
                </div>
        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Temperature</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="weatherTable">
                        <!-- Weather data rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
        </div>
    </div> 
    <div class="log-window">
        <h3>Data History</h3>
        <ul id="log-list">
            <!-- Log entries will be added here -->
        </ul>
    </div>       
</div>

<!-- <script src="/task1-weatherApp/public/js/custom-table.js"></script> -->

<script src="/task1-weatherApp/public/js/main.js"></script>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../templates/footer.php'; // Include the footer template ?>