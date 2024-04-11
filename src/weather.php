<?php
require 'db.php';
require 'config.php';

if (isset($_POST['lat']) && isset($_POST['lon'])) {
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
    
    echo "Weather for {$city}: {$temperature}°C, {$description}";
} else {
    echo "Latitude and Longitude required.";
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
