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
function addLogEntry(entry) {
    $('#log-list').prepend('<li>' + entry + '</li>');
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
                fetchAllWeather(); // Refresh the weather data table
                addLogEntry("New weather data for " + data.city + " saved at " + new Date().toLocaleString());

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
                var row = $('<tr></tr>').data('id', record.id); // Add data-id attribute for reference
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
                            editRow(this);
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
function editRow(button) {
    var row = $(button).closest('tr');
    
    // Check if we are already in edit mode by checking for the presence of input fields
    if (row.find('input').length > 0) {
        return; // Exit the function if we're already editing this row
    }
    
    var city = row.find('td:eq(0)').text();
    var temperature = row.find('td:eq(1)').text().replace('°C', ''); // Remove '°C' to get only the number
    var description = row.find('td:eq(2)').text();
    
    // Make the row editable
    row.find('td:eq(0)').html('<input type="text" class="form-control" value="' + city + '">');
    row.find('td:eq(1)').html('<input type="text" class="form-control" value="' + temperature + '">');
    row.find('td:eq(2)').html('<input type="text" class="form-control" value="' + description + '">');
    
    // Hide the "Edit" button and add a "Save" button if it doesn't exist
    row.find('.edit').hide();
    if (row.find('.save').length === 0) {
        row.find('td:eq(4)').prepend('<button class="save">Save</button>');
    }
    
    // Bind the saveRow function to the "Save" button
    row.find('.save').click(function() {
        saveRow(this);
    });
}


function saveRow(button) {
    var row = $(button).closest('tr');
    var id = row.data('id');
    var city = row.find('td:eq(0) input').val();
    var temperature = row.find('td:eq(1) input').val();
    var description = row.find('td:eq(2) input').val();

    // Call the update function
    updateWeather(id, city, temperature, description, function() {
        // After successful update, revert inputs back to text
        row.find('td:eq(0)').text(city);
        row.find('td:eq(1)').text(temperature + '°C');
        row.find('td:eq(2)').text(description);
        row.find('.edit').show(); // Show the edit button again
        row.find('.save').remove(); // Remove the save button
    });
}

function updateWeather(id, city, temperature, description, onSuccess) {
        console.log("Sending update for city:", city); // Add this for debugging

    $.ajax({
        url: '/task1-weatherApp/src/manageWeather.php',
        type: 'POST',
        data: {
            action: 'update',
            id: id,
            city: city,
            temperature: temperature,
            description: description
        },
        success: function(response) {
            if (response.status === 'success') {
                alert('Record updated successfully');
                onSuccess(); // Call onSuccess callback function
            } else {
                alert('Failed to update the record.');
            }
        }
    });
}


fetchAllWeather();
