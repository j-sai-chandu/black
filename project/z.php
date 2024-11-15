<?php
// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "project"; // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the `id` from the URL query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    die("ID parameter is required.");
}

// Query to fetch `couple_places` and other destination categories based on `id`
$sql = "SELECT couple_places, couple_includes_beaches, couple_includes_hill_stations, 
            couple_includes_museums, couple_includes_temples, couple_includes_historical_sites, 
            couple_includes_waterfalls, couple_includes_cultural_sites, couple_includes_adventures, 
            couple_includes_relaxation, couple_includes_caves, couple_includes_volcanoes 
        FROM destinations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // bind `id` as integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the result and get all data
    $row = $result->fetch_assoc();
    $couplePlaces = $row['couple_places'];

    // Convert `couple_places` comma-separated values into an array
    $placesArray = explode(',', $couplePlaces);

    // Store other non-empty category values in an associative array
    $additionalPlaces = [];
    $categories = [
        "Beaches" => $row['couple_includes_beaches'],
        "Hill Stations" => $row['couple_includes_hill_stations'],
        "Museums" => $row['couple_includes_museums'],
        "Temples" => $row['couple_includes_temples'],
        "Historical Sites" => $row['couple_includes_historical_sites'],
        "Waterfalls" => $row['couple_includes_waterfalls'],
        "Cultural Sites" => $row['couple_includes_cultural_sites'],
        "Adventures" => $row['couple_includes_adventures'],
        "Relaxation" => $row['couple_includes_relaxation'],
        "Caves" => $row['couple_includes_caves'],
        "Volcanoes" => $row['couple_includes_volcanoes']
    ];

    // Only include non-empty categories in the display list
    foreach ($categories as $categoryName => $categoryValue) {
        if (!empty($categoryValue)) {
            $additionalPlaces[$categoryName] = $categoryValue;
        }
    }
} else {
    echo "No data found for this ID.";
    exit;
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Couple Places</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            margin-bottom: 20px;
        }
        .places-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            width: 80%;
            max-width: 800px;
            margin-bottom: 20px;
        }
        .place-card {
            background-color: #1e1e1e;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .place-card.selected {
            background-color: #2e7d32;
            transform: scale(1.05);
        }
        .place-card h2 {
            margin: 0;
            font-size: 1.1em;
        }
        .price-tier {
            margin-top: 5px;
            font-size: 0.9em;
            color: #ffcc00;
            font-weight: bold;
        }
        .build-button {
            padding: 10px 20px;
            font-size: 1.1em;
            font-weight: bold;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .build-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Select Your Destinations</h1>

    <div class="places-container">
        <?php
        // Loop through the main places array and display each place
        foreach ($placesArray as $place) {
            $place = trim($place);
            $priceTier = "Budget"; // Placeholder price tier; replace with actual data if available

            echo "<div class='place-card' onclick='toggleSelection(this, \"" . htmlspecialchars($place) . "\")'>";
            echo "<h2>" . htmlspecialchars($place) . "</h2>";
            echo "<div class='price-tier'>" . htmlspecialchars($priceTier) . "</div>";
            echo "</div>";
        }

        // Loop through additional places and display each category if not empty
        foreach ($additionalPlaces as $category => $location) {
            echo "<div class='place-card' onclick='toggleSelection(this, \"" . htmlspecialchars($category) . "\")'>";
            echo "<h2>" . htmlspecialchars($category) . "</h2>";
            echo "<div class='price-tier'>" . htmlspecialchars($location) . "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <button class="build-button" onclick="buildSelectedDestinations()">Build</button>

    <script>
        let selectedDestinations = [];

        function toggleSelection(element, destination) {
            // Toggle selected class
            element.classList.toggle("selected");

            // Add or remove destination from selected list
            if (selectedDestinations.includes(destination)) {
                selectedDestinations = selectedDestinations.filter(d => d !== destination);
            } else {
                selectedDestinations.push(destination);
            }
        }

        function buildSelectedDestinations() {
            if (selectedDestinations.length === 0) {
                alert("Please select at least one destination.");
                return;
            }

            // Send selected destinations to another page or process them here
            alert("Selected Destinations: " + selectedDestinations.join(", "));
            
            // Example: you could send the data to another PHP file for processing
            // window.location.href = "processSelection.php?destinations=" + encodeURIComponent(selectedDestinations.join(","));
        }
    </script>

</body>
</html>
