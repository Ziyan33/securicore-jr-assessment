function logout() {
    document.location = '/task1-weatherApp/src/logout.php';
}

// Validate input fields
function validateInput() {
    var lat = document.getElementById('lat').value;
    var lon = document.getElementById('lon').value;
    if (isNaN(lat) || isNaN(lon) || lat < -90 || lat > 90 || lon < -180 || lon > 180) {
        alert("Please enter valid latitude and longitude values.");
        return false;
    }
    return true;
}

// Fetch weather data using validated inputs
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
        dataType: 'json',  // Expecting JSON response
        success: function(data) {
            if(data.error) {
                alert(data.error);
            } else {
                updateWeatherCard(data);
            }
        },
        error: function(xhr) {
            alert('Failed to fetch weather data. Error: ' + xhr.statusText);
        }
    });
}
// Function to update the weather card with fetched data
function updateWeatherCard(data) {
    var weatherCard = document.getElementById('weatherCard');
    weatherCard.style.display = 'block';
    document.getElementById('city').textContent = data.city || 'Unknown';
    document.getElementById('temperature').textContent = 'Temperature: ' + data.temperature + '°C';
    document.getElementById('weather-description').textContent = 'Description: ' + data.description;
    document.getElementById('recorded_at').textContent = 'Date: ' + data.recorded_at;
}