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

// Query to fetch `couple_places`, `couple_best_time`, and `couple_min_cost` based on `id`
$sql = "SELECT couple_places, couple_best_time, couple_min_cost FROM destinations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // bind `id` as integer
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays to avoid undefined variable errors
$placesArray = [];
$bestTimeArray = [];
$minCostArray = [];
$totalCost = 0;  // Initialize total cost

// Fetch data if available
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $couplePlaces = $row['couple_places'];
    $coupleBestTime = $row['couple_best_time'];
    $coupleMinCost = $row['couple_min_cost'];

    // Convert comma-separated values into arrays
    $placesArray = !empty($couplePlaces) ? explode(',', $couplePlaces) : [];
    $bestTimeArray = !empty($coupleBestTime) ? explode(',', $coupleBestTime) : [];
    $minCostArray = !empty($coupleMinCost) ? explode(',', $coupleMinCost) : [];
    
    // Calculate total cost by summing up the costs
    foreach ($minCostArray as $cost) {
        // Remove currency symbol if it exists and add cost to total
        $cleanCost = preg_replace('/[^0-9.]/', '', $cost); // Removes any non-numeric characters
        $totalCost += (float)$cleanCost; // Add the cleaned cost to the total
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
    <title>RoadMap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        h1 {
            margin-bottom: 20px;
        }
        .places-container {
            width: 90%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .place-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e1e;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s, transform 0.2s;
        }
        .place-card:hover {
            background-color: #2e7d32;
            transform: scale(1.02);
        }
        .place-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .serial-number {
            font-weight: bold;
            font-size: 1em;
            color: #ffffff;
        }
        .place-card h2 {
            margin: 0;
            font-size: 1em;
        }
        .details {
            display: flex;
            align-items: center;
            gap: 20px;
            text-align: left;
        }
        .time {
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .cost {
            font-size: 0.9em;
            color: #ffcc00;
            font-weight: bold;
        }
        .total-cost {
            margin-top: 20px;
            font-size: 1.2em;
            color: #ffcc00;
            font-weight: bold;
            text-align: center; /* Center the text */
            width: 100%; /* Ensures the element spans the width */
        }
        .view-button {
            background-color: #2e7d32;
            color: #ffffff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .view-button:hover {
            background-color: #1e5a26;
        }
        .note {
            margin-top: 40px;
            font-size: 1em;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            background-color: #333;
            border-radius: 8px;
            max-width: 80%;
            line-height: 1.5;
        }
        .feedback-container {
            margin-top: 20px;
            text-align: center;
        }
        .feedback-button {
            background-color: #2e7d32;
            color: #ffffff;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
        }
        .feedback-button:hover {
            background-color: #1e5a26;
        }
    </style>
</head>
<body>

    <h1>RoadMap</h1>

    <div class="places-container">
        <?php
        // Loop through the places array and display each place with corresponding best time and minimum cost
        if (count($placesArray) > 0) {
            for ($i = 0; $i < count($placesArray); $i++) {
                $place = trim($placesArray[$i]);
                $bestTime = isset($bestTimeArray[$i]) ? $bestTimeArray[$i] : 'No best time available';
                $minCost = isset($minCostArray[$i]) ? $minCostArray[$i] : 'No cost available';

                // Get the ordinal number for "1st", "2nd", "3rd" etc.
                $ordinal = $i + 1;
                $suffix = 'th'; // Default suffix
                if ($ordinal % 10 == 1 && $ordinal != 11) {
                    $suffix = 'st';
                } elseif ($ordinal % 10 == 2 && $ordinal != 12) {
                    $suffix = 'nd';
                } elseif ($ordinal % 10 == 3 && $ordinal != 13) {
                    $suffix = 'rd';
                }

                $ordinalLabel = $ordinal . $suffix; // Label like "1st place to visit"

                // Display the ordinal label before the place card
                echo "<div class='place-card'>";
                echo "<div class='place-info'>";
                echo "<span class='serial-number'>" . htmlspecialchars($ordinalLabel) . "</span>"; // Display ordinal label
                echo "<h2>" . htmlspecialchars($place) . "</h2>";
                echo "</div>";
                
                // Display the best time, cost, and view button horizontally
                echo "<div class='details'>";
                echo "<div class='time'>" . htmlspecialchars($bestTime) . "</div>";
                echo "<div class='cost'>" . htmlspecialchars($minCost) . "</div>";
                
                // View button linking to Google Maps for the current place
                $googleMapsUrl = "https://www.google.com/maps?q=" . urlencode($place);
                echo "<button class='view-button' onclick='window.open(\"$googleMapsUrl\", \"_blank\")'>View</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No places available to display.</p>";
        }
        ?>
        
        <!-- Display Total Cost -->
        <div class="total-cost">
            Total Travel Expenses: €<?php echo number_format($totalCost, 2); ?> <!-- Format total cost -->
        </div>

        <!-- Added Feedback Button -->
        <div class="feedback-container">
            <button class="feedback-button" onclick="window.location.href='review/review_form.html';">Give Feedback</button>
        </div>
    </div>

    <!-- Added Note Section -->
    <div class="note">
        Note: This is the minimum travel cost, calculated for bus travel when you are inside the capital city center. It may vary for you based on your travel type and your location.
    </div>

</body>
</html>
