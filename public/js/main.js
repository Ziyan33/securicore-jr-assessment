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
    console.log("Latitude: ", lat, "Longitude: ", lon);

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
function fetchAllWeather() {
    $.ajax({
        url: '/task1-weatherApp/src/weather.php',  // Adjust this path as needed
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Error fetching data:', data.error);
                return;
            }
            
            var tableBody = $('#weatherTable');
            tableBody.empty();  // Clear existing table data

            data.forEach(function(record) {
                var row = $('<tr></tr>');
                row.append($('<td></td>').text(record.city));
                row.append($('<td></td>').text(record.temperature + '°C'));
                row.append($('<td></td>').text(record.description));
                row.append($('<td></td>').text(record.recorded_at));
                row.append(
                    $('<td></td>').append(
                        $('<button>Delete</button>').click(function() {
                            deleteWeather(record.id);
                        })
                    ).append(
                        $('<button>Update</button>').click(function() {
                            updateWeather(record.id, record.temperature, record.description);
                        })
                    )
                );

                tableBody.append(row);
            });
        },
        error: function(xhr) {
            console.error('Failed to fetch weather data:', xhr);
        }
    });
}



function deleteWeather(id) {
    $.ajax({
        url: '/task1-weatherApp/src/manageWeather.php',
        type: 'POST',
        data: { action: 'delete', id: id },
        success: function(response) {
            alert(response.message);
            fetchAllWeather(); // Refresh the table
        }
    });
}

function updateWeather(id, temperature, description) {
    // Add logic to capture new temperature and description values if needed
    $.ajax({
        url: '/task1-weatherApp/src/manageWeather.php',
        type: 'POST',
        data: { action: 'update', id: id, temperature: temperature, description: description },
        success: function(response) {
            alert(response.message);
            fetchAllWeather(); // Refresh the table
        }
    });
}

// Call this function when the page loads to populate the table
fetchAllWeather();
