<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$place_data = [];
if (isset($_GET['place_name'])) {
    $place_name = $conn->real_escape_string($_GET['place_name']);
    $sql = "SELECT * FROM destinations WHERE place_name = '$place_name'";
    $result = $conn->query($sql);
    $place_data = $result->fetch_assoc();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designation</title>
    <link rel="stylesheet" href="adminAddCountry.css">
</head>
<body>
<div class="form-container">
    <div class="go-back">
        <img src="photo/go-back-image.png" alt="Go Back" onclick="goBack()">
    </div>

    <h2>Edit Designation</h2>
    <form action="updateDestination.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="original_place_name" value="<?php echo htmlspecialchars($place_data['place_name']); ?>">
        <input type="text" name="place_name" value="<?php echo htmlspecialchars($place_data['place_name']); ?>" required>

        <!-- Couple Section -->
        <h3>Couple</h3>
        <input type="text" name="couple_places" value="<?php echo htmlspecialchars($place_data['couple_places']); ?>" placeholder="Nearby Places for Couple">
        <input type="text" name="couple_best_time" value="<?php echo htmlspecialchars($place_data['couple_best_time']); ?>" placeholder="Best Time for Couple">
        <label>Worst months to visit for Couple:</label>
        <div class="months-container">
            <?php
            $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            foreach ($months as $month) {
                $checked = strpos($place_data['couple_worst_months'], $month) !== false ? 'checked' : '';
                echo "<label><input type='checkbox' name='couple_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>
        <input type="number" name="couple_min_cost" value="<?php echo htmlspecialchars($place_data['couple_min_cost']); ?>" placeholder="Minimum Cost">
        <label>Upload new images for Couple:</label>
        <input type="file" name="couple_images[]" multiple>

        <!-- Includes Section -->
        <div class="include-container">
            <h4>Includes:</h4>
            <?php
            $include_fields = ['beaches', 'hill_stations', 'museums', 'temples', 'historical_sites', 'waterfalls', 'cultural_sites', 'adventures', 'relaxation', 'caves', 'volcanoes'];
            foreach ($include_fields as $field) {
                echo "<input type='text' name='includes[$field]' value='" . htmlspecialchars($place_data[$field] ?? '') . "' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "'>";
            }
            ?>
        </div>

        <!-- Repeat for Family, Friends, Solo Sections -->

        <!-- Family Section -->
        <h3>Family</h3>
        <input type="text" name="family_places" value="<?php echo htmlspecialchars($place_data['family_places']); ?>" placeholder="Nearby Places for Family">
        <input type="text" name="family_best_time" value="<?php echo htmlspecialchars($place_data['family_best_time']); ?>" placeholder="Best Time for Family">
        <label>Worst months to visit for Family:</label>
        <div class="months-container">
            <?php
            foreach ($months as $month) {
                $checked = strpos($place_data['family_worst_months'], $month) !== false ? 'checked' : '';
                echo "<label><input type='checkbox' name='family_worst_months[]' value='$month' $checked> $month</label>";
            }
            ?>
        </div>
        <input type="number" name="family_min_cost" value="<?php echo htmlspecialchars($place_data['family_min_cost']); ?>" placeholder="Minimum Cost">
        <label>Upload new images for Family:</label>
        <input type="file" name="family_images[]" multiple>

        <div class="include-container">
            <h4>Includes:</h4>
            <?php
            $include_fields = ['beaches', 'hill_stations', 'museums', 'temples', 'historical_sites', 'waterfalls', 'cultural_sites', 'adventures', 'relaxation', 'caves', 'volcanoes'];
            foreach ($include_fields as $field) {
                echo "<input type='text' name='includes[$field]' value='" . htmlspecialchars($place_data[$field] ?? '') . "' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "'>";
            }
            ?>
        </div>
        <!-- Friends Section -->
<h3>Friends</h3>
<input type="text" name="friends_places" value="<?php echo htmlspecialchars($place_data['friends_places']); ?>" placeholder="Nearby Places for Friends">
<input type="text" name="friends_best_time" value="<?php echo htmlspecialchars($place_data['friends_best_time']); ?>" placeholder="Best Time for Friends">
<label>Worst months to visit for Friends:</label>
<div class="months-container">
    <?php
    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    foreach ($months as $month) {
        $checked = strpos($place_data['friends_worst_months'], $month) !== false ? 'checked' : '';
        echo "<label><input type='checkbox' name='friends_worst_months[]' value='$month' $checked> $month</label>";
    }
    ?>
</div>
<input type="number" name="friends_min_cost" value="<?php echo htmlspecialchars($place_data['friends_min_cost']); ?>" placeholder="Minimum Cost">
<label>Upload new images for Friends:</label>
<input type="file" name="friends_images[]" multiple>

<!-- Includes Section for Friends -->
<div class="include-container">
    <h4>Includes:</h4>
    <?php
    $include_fields = ['beaches', 'hill_stations', 'museums', 'temples', 'historical_sites', 'waterfalls', 'cultural_sites', 'adventures', 'relaxation', 'caves', 'volcanoes'];
    foreach ($include_fields as $field) {
        echo "<input type='text' name='includes[$field]' value='" . htmlspecialchars($place_data[$field] ?? '') . "' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "'>";
    }
    ?>
</div>

<!-- Solo Section -->
<h3>Solo</h3>
<input type="text" name="solo_places" value="<?php echo htmlspecialchars($place_data['solo_places']); ?>" placeholder="Nearby Places for Solo">
<input type="text" name="solo_best_time" value="<?php echo htmlspecialchars($place_data['solo_best_time']); ?>" placeholder="Best Time for Solo">
<label>Worst months to visit for Solo:</label>
<div class="months-container">
    <?php
    foreach ($months as $month) {
        $checked = strpos($place_data['solo_worst_months'], $month) !== false ? 'checked' : '';
        echo "<label><input type='checkbox' name='solo_worst_months[]' value='$month' $checked> $month</label>";
    }
    ?>
</div>
<input type="number" name="solo_min_cost" value="<?php echo htmlspecialchars($place_data['solo_min_cost']); ?>" placeholder="Minimum Cost">
<label>Upload new images for Solo:</label>
<input type="file" name="solo_images[]" multiple>

<!-- Includes Section for Solo -->
<div class="include-container">
    <h4>Includes:</h4>
    <?php
    $include_fields = ['beaches', 'hill_stations', 'museums', 'temples', 'historical_sites', 'waterfalls', 'cultural_sites', 'adventures', 'relaxation', 'caves', 'volcanoes'];
    foreach ($include_fields as $field) {
        echo "<input type='text' name='includes[$field]' value='" . htmlspecialchars($place_data[$field] ?? '') . "' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "'>";
    }
    ?>
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
