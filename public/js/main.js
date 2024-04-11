// Validate input fields
function validateInput() {
    var lat = parseFloat(document.getElementById('lat').value);
    var lon = parseFloat(document.getElementById('lon').value);
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
        success: function(response) {
            $('#weatherResult').html(response);
        }
    });
}
