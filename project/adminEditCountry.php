<?php
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "project";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id']; // The ID of the destination to edit

    // Retrieve destination data from the database
    $query = "SELECT * FROM destinations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $destination = $result->fetch_assoc();

    // Assuming that the retrieved data is stored in $destination
} else {
    // Redirect or handle the case when there's no ID passed
    echo "No destination selected for editing.";
    exit;
}
?>

<!-- The form below will pre-fill using the retrieved $destination data -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination</title>
    <link rel="stylesheet" href="adminAddCountry.css">
</head>
<body>

<div class="form-container">
    <div class="go-back">
        <img src="photo/go-back-image.png" alt="Go Back" onclick="goBack()">
    </div>

    <h2>Edit Destination</h2>
    <form id="destinationForm" action="updateDestination.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $destination['id']; ?>">
        <input type="text" name="place_name" value="<?php echo $destination['place_name']; ?>" placeholder="Give Name of the Place" required>

        <!-- Couple Section -->
        <h3>Couple</h3>
        <input type="text" name="couple_places" value="<?php echo $destination['couple_places']; ?>" placeholder="Add nearby Places for Couple with comma separation">
        <input type="text" name="couple_best_time" value="<?php echo $destination['couple_best_time']; ?>" placeholder="Add best time for Couple with comma separation">
        
        <!-- Worst months for Couple -->
        <label>Worst months to visit for Couple:</label>
        <div class="months-container">
            <?php
            $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            foreach ($months as $month) {
                $checked = in_array($month, explode(",", $destination['couple_worst_months'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='couple_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>

        <input type="number" name="couple_min_cost" value="<?php echo $destination['couple_min_cost']; ?>" placeholder="Minimum Cost to visit all these places">
        <input type="file" name="couple_images[]" multiple>

            <h4 style="color:#666">Includes:</h4>
            <input type="text" name="couple_includes_beaches" value="<?php echo $destination['couple_includes_beaches']; ?>" placeholder="couple_includes_beaches">
            <input type="text" name="couple_includes_hill_stations" value="<?php echo $destination['couple_includes_hill_stations']; ?>" placeholder="couple_includes_hill_stations">
            <input type="text" name="couple_includes_museums" value="<?php echo $destination['couple_includes_museums']; ?>" placeholder="couple_includes_museums">
            <input type="text" name="couple_includes_temples" value="<?php echo $destination['couple_includes_temples']; ?>" placeholder="couple_includes_temples">
            <input type="text" name="couple_includes_historical_sites" value="<?php echo $destination['couple_includes_historical_sites']; ?>" placeholder="couple_includes_historical_sites">
            <input type="text" name="couple_includes_waterfalls" value="<?php echo $destination['couple_includes_waterfalls']; ?>" placeholder="couple_includes_waterfalls">
            <input type="text" name="couple_includes_cultural_sites" value="<?php echo $destination['couple_includes_cultural_sites']; ?>" placeholder="couple_includes_cultural_sites">
            <input type="text" name="couple_includes_adventures" value="<?php echo $destination['couple_includes_adventures']; ?>" placeholder="couple_includes_adventures">
            <input type="text" name="couple_includes_relaxation" value="<?php echo $destination['couple_includes_relaxation']; ?>" placeholder="couple_includes_relaxation">
            <input type="text" name="couple_includes_caves" value="<?php echo $destination['couple_includes_caves']; ?>" placeholder="couple_includes_caves">
            <input type="text" name="couple_includes_volcanoes" value="<?php echo $destination['couple_includes_volcanoes']; ?>" placeholder="couple_includes_volcanoes">


        
        <!-- Family Section -->
        <h3>Family</h3>
        <input type="text" name="family_places" value="<?php echo $destination['family_places']; ?>" placeholder="Add nearby Places for Family with comma separation">
        <input type="text" name="family_best_time" value="<?php echo $destination['family_best_time']; ?>" placeholder="Add best time for Family with comma separation">
        
        <!-- Worst months for Family -->
        <label>Worst months to visit for Family:</label>
        <div class="months-container">
            <?php
            foreach ($months as $month) {
                $checked = in_array($month, explode(",", $destination['family_worst_months'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='family_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>

        <input type="number" name="family_min_cost" value="<?php echo $destination['family_min_cost']; ?>" placeholder="Minimum Cost to visit all these places">
        <input type="file" name="family_images[]" multiple>

        <h4 style="color:#666">Includes:</h4>
            <input type="text" name="family_includes_beaches" value="<?php echo $destination['family_includes_beaches']; ?>" placeholder="family_includes_beaches">
            <input type="text" name="family_includes_hill_stations" value="<?php echo $destination['family_includes_hill_stations']; ?>" placeholder="family_includes_hill_stations">
            <input type="text" name="family_includes_museums" value="<?php echo $destination['family_includes_museums']; ?>" placeholder="family_includes_museums">
            <input type="text" name="family_includes_temples" value="<?php echo $destination['family_includes_temples']; ?>" placeholder="family_includes_temples">
            <input type="text" name="family_includes_historical_sites" value="<?php echo $destination['family_includes_historical_sites']; ?>" placeholder="family_includes_historical_sites">
            <input type="text" name="family_includes_waterfalls" value="<?php echo $destination['family_includes_waterfalls']; ?>" placeholder="family_includes_waterfalls">
            <input type="text" name="family_includes_cultural_sites" value="<?php echo $destination['family_includes_cultural_sites']; ?>" placeholder="family_includes_cultural_sites">
            <input type="text" name="family_includes_adventures" value="<?php echo $destination['family_includes_adventures']; ?>" placeholder="family_includes_adventures">
            <input type="text" name="family_includes_relaxation" value="<?php echo $destination['family_includes_relaxation']; ?>" placeholder="family_includes_relaxation">
            <input type="text" name="family_includes_caves" value="<?php echo $destination['family_includes_caves']; ?>" placeholder="family_includes_caves">
            <input type="text" name="family_includes_volcanoes" value="<?php echo $destination['family_includes_volcanoes']; ?>" placeholder="family_includes_volcanoes">



        <!-- Friends Section -->
        <h3>Friends</h3>
        <input type="text" name="friends_places" value="<?php echo $destination['friends_places']; ?>" placeholder="Add nearby Places for Friends with comma separation">
        <input type="text" name="friends_best_time" value="<?php echo $destination['friends_best_time']; ?>" placeholder="Add best time for Friends with comma separation">
        
        <!-- Worst months for Friends -->
        <label>Worst months to visit for Friends:</label>
        <div class="months-container">
            <?php
            foreach ($months as $month) {
                $checked = in_array($month, explode(",", $destination['friends_worst_months'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='friends_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>

        <input type="number" name="friends_min_cost" value="<?php echo $destination['friends_min_cost']; ?>" placeholder="Minimum Cost to visit all these places">
        <input type="file" name="friends_images[]" multiple>

        <div class="include-container">
        <h4 style="color:#666">Includes:</h4>
            <input type="text" name="friends_includes_beaches" value="<?php echo $destination['friends_includes_beaches']; ?>" placeholder="friends_includes_beaches">
            <input type="text" name="friends_includes_hill_stations" value="<?php echo $destination['friends_includes_hill_stations']; ?>" placeholder="friends_includes_hill_stations">
            <input type="text" name="friends_includes_museums" value="<?php echo $destination['friends_includes_museums']; ?>" placeholder="friends_includes_museums">
            <input type="text" name="friends_includes_temples" value="<?php echo $destination['friends_includes_temples']; ?>" placeholder="friends_includes_temples">
            <input type="text" name="friends_includes_historical_sites" value="<?php echo $destination['friends_includes_historical_sites']; ?>" placeholder="friends_includes_historical_sites">
            <input type="text" name="friends_includes_waterfalls" value="<?php echo $destination['friends_includes_waterfalls']; ?>" placeholder="friends_includes_waterfalls">
            <input type="text" name="friends_includes_cultural_sites" value="<?php echo $destination['friends_includes_cultural_sites']; ?>" placeholder="friends_includes_cultural_sites">
            <input type="text" name="friends_includes_adventures" value="<?php echo $destination['friends_includes_adventures']; ?>" placeholder="friends_includes_adventures">
            <input type="text" name="friends_includes_relaxation" value="<?php echo $destination['friends_includes_relaxation']; ?>" placeholder="friends_includes_relaxation">
            <input type="text" name="friends_includes_caves" value="<?php echo $destination['friends_includes_caves']; ?>" placeholder="friends_includes_caves">
            <input type="text" name="friends_includes_volcanoes" value="<?php echo $destination['friends_includes_volcanoes']; ?>" placeholder="friends_includes_volcanoes">


        </div>

        <!-- Solo Section -->
        <h3>Solo</h3>
        <input type="text" name="solo_places" value="<?php echo $destination['solo_places']; ?>" placeholder="Add nearby Places for Solo with comma separation">
        <input type="text" name="solo_best_time" value="<?php echo $destination['solo_best_time']; ?>" placeholder="Add best time for Solo with comma separation">
        
        <!-- Worst months for Solo -->
        <label>Worst months to visit for Solo:</label>
        <div class="months-container">
            <?php
            foreach ($months as $month) {
                $checked = in_array($month, explode(",", $destination['solo_worst_months'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='solo_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>

        <input type="number" name="solo_min_cost" value="<?php echo $destination['solo_min_cost']; ?>" placeholder="Minimum Cost to visit all these places">
        <input type="file" name="solo_images[]" multiple>

        <div class="include-container">
        <h4 style="color:#666">Includes:</h4>
            <input type="text" name="solo_includes_beaches" value="<?php echo $destination['solo_includes_beaches']; ?>" placeholder="solo_includes_beaches">
            <input type="text" name="solo_includes_hill_stations" value="<?php echo $destination['solo_includes_hill_stations']; ?>" placeholder="solo_includes_hill_stations">
            <input type="text" name="solo_includes_museums" value="<?php echo $destination['solo_includes_museums']; ?>" placeholder="solo_includes_museums">
            <input type="text" name="solo_includes_temples" value="<?php echo $destination['solo_includes_temples']; ?>" placeholder="solo_includes_temples">
            <input type="text" name="solo_includes_historical_sites" value="<?php echo $destination['solo_includes_historical_sites']; ?>" placeholder="solo_includes_historical_sites">
            <input type="text" name="solo_includes_waterfalls" value="<?php echo $destination['solo_includes_waterfalls']; ?>" placeholder="solo_includes_waterfalls">
            <input type="text" name="solo_includes_cultural_sites" value="<?php echo $destination['solo_includes_cultural_sites']; ?>" placeholder="solo_includes_cultural_sites">
            <input type="text" name="solo_includes_adventures" value="<?php echo $destination['solo_includes_adventures']; ?>" placeholder="solo_includes_adventures">
            <input type="text" name="solo_includes_relaxation" value="<?php echo $destination['solo_includes_relaxation']; ?>" placeholder="solo_includes_relaxation">
            <input type="text" name="solo_includes_caves" value="<?php echo $destination['solo_includes_caves']; ?>" placeholder="solo_includes_caves">
            <input type="text" name="solo_includes_volcanoes" value="<?php echo $destination['solo_includes_volcanoes']; ?>" placeholder="solo_includes_volcanoes">


        </div>

        <button type="submit">Save Changes</button>
    </form>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
