<?php
require 'db.php';
require 'config.php';

header('Content-Type: application/json'); 

// Fetch and output all weather data for GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM weather ORDER BY recorded_at DESC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit; // Stop the script here after handling GET request
}


// if (isset($_POST['lat']) && isset($_POST['lon'])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lat']) && isset($_POST['lon'])) {

    $lat = floatval($_POST['lat']);
    $lon = floatval($_POST['lon']);

    // Validate latitude and longitude
    if ($lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
        echo "Invalid latitude or longitude values.";
        exit;
    }

    $apiKey = WEATHER_APP_API_KEY;
    $weatherData = getWeatherData($lat, $lon, $apiKey);

    if (!$weatherData || !isset($weatherData['main']['temp'], $weatherData['weather'][0]['description'])) {
        echo "The latitude and longitude you entered do not correspond to a valid location.";
        exit;
    }

    $temperature = $weatherData['main']['temp'];
    $description = $weatherData['weather'][0]['description'];
    $city = $weatherData['name'] ?? 'Unknown location';

    $stmt = $pdo->prepare("INSERT INTO weather (temperature, description, city) VALUES (?, ?, ?)");
    $stmt->execute([$temperature, $description, $city]);
    
    echo json_encode([
        "city" => $city,
        "temperature" => $temperature,
        "description" => $description,
        "recorded_at" => date('Y-m-d H:i:s')  // assuming you want to send the current date/time as recorded_at
    ]);
} else {
    echo json_encode(["error" => "Latitude and Longitude required."]);
}

function getWeatherData($lat, $lon, $apiKey) {
    $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    curl_close($ch);
    return json_decode($response, true);
}