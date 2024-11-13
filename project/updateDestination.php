<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$place_name = $_POST['place_name'];
$id = $_POST['id']; // Assuming the ID is passed from a form

// Couple Section
$couple_places = $_POST['couple_places'];
$couple_best_time = $_POST['couple_best_time'];
$couple_worst_months = implode(',', $_POST['couple_worst_months']);
$couple_min_cost = $_POST['couple_min_cost'];
$couple_images = implode(',', $_FILES['couple_images']['name']);
$couple_includes_beaches = $_POST['couple_includes_beaches'];
$couple_includes_hill_stations = $_POST['couple_includes_hill_stations'];
$couple_includes_museums = $_POST['couple_includes_museums'];
$couple_includes_temples = $_POST['couple_includes_temples'];
$couple_includes_historical_sites = $_POST['couple_includes_historical_sites'];
$couple_includes_waterfalls = $_POST['couple_includes_waterfalls'];
$couple_includes_cultural_sites = $_POST['couple_includes_cultural_sites'];
$couple_includes_adventures = $_POST['couple_includes_adventures'];
$couple_includes_relaxation = $_POST['couple_includes_relaxation'];
$couple_includes_caves = $_POST['couple_includes_caves'];
$couple_includes_volcanoes = $_POST['couple_includes_volcanoes'];

// Family Section
$family_places = $_POST['family_places'];
$family_best_time = $_POST['family_best_time'];
$family_worst_months = implode(',', $_POST['family_worst_months']);
$family_min_cost = $_POST['family_min_cost'];
$family_images = implode(',', $_FILES['family_images']['name']);
$family_includes_beaches = $_POST['family_includes_beaches'];
$family_includes_hill_stations = $_POST['family_includes_hill_stations'];
$family_includes_museums = $_POST['family_includes_museums'];
$family_includes_temples = $_POST['family_includes_temples'];
$family_includes_historical_sites = $_POST['family_includes_historical_sites'];
$family_includes_waterfalls = $_POST['family_includes_waterfalls'];
$family_includes_cultural_sites = $_POST['family_includes_cultural_sites'];
$family_includes_adventures = $_POST['family_includes_adventures'];
$family_includes_relaxation = $_POST['family_includes_relaxation'];
$family_includes_caves = $_POST['family_includes_caves'];
$family_includes_volcanoes = $_POST['family_includes_volcanoes'];

// Friends Section
$friends_places = $_POST['friends_places'];
$friends_best_time = $_POST['friends_best_time'];
$friends_worst_months = implode(',', $_POST['friends_worst_months']);
$friends_min_cost = $_POST['friends_min_cost'];
$friends_images = implode(',', $_FILES['friends_images']['name']);
$friends_includes_beaches = $_POST['friends_includes_beaches'];
$friends_includes_hill_stations = $_POST['friends_includes_hill_stations'];
$friends_includes_museums = $_POST['friends_includes_museums'];
$friends_includes_temples = $_POST['friends_includes_temples'];
$friends_includes_historical_sites = $_POST['friends_includes_historical_sites'];
$friends_includes_waterfalls = $_POST['friends_includes_waterfalls'];
$friends_includes_cultural_sites = $_POST['friends_includes_cultural_sites'];
$friends_includes_adventures = $_POST['friends_includes_adventures'];
$friends_includes_relaxation = $_POST['friends_includes_relaxation'];
$friends_includes_caves = $_POST['friends_includes_caves'];
$friends_includes_volcanoes = $_POST['friends_includes_volcanoes'];

// Solo Section
$solo_places = $_POST['solo_places'];
$solo_best_time = $_POST['solo_best_time'];
$solo_worst_months = implode(',', $_POST['solo_worst_months']);
$solo_min_cost = $_POST['solo_min_cost'];
$solo_images = implode(',', $_FILES['solo_images']['name']);
$solo_includes_beaches = $_POST['solo_includes_beaches'];
$solo_includes_hill_stations = $_POST['solo_includes_hill_stations'];
$solo_includes_museums = $_POST['solo_includes_museums'];
$solo_includes_temples = $_POST['solo_includes_temples'];
$solo_includes_historical_sites = $_POST['solo_includes_historical_sites'];
$solo_includes_waterfalls = $_POST['solo_includes_waterfalls'];
$solo_includes_cultural_sites = $_POST['solo_includes_cultural_sites'];
$solo_includes_adventures = $_POST['solo_includes_adventures'];
$solo_includes_relaxation = $_POST['solo_includes_relaxation'];
$solo_includes_caves = $_POST['solo_includes_caves'];
$solo_includes_volcanoes = $_POST['solo_includes_volcanoes'];

// Update data in the database
$sql = "UPDATE destinations SET
    place_name = '$place_name',
    couple_places = '$couple_places',
    couple_best_time = '$couple_best_time',
    couple_worst_months = '$couple_worst_months',
    couple_min_cost = '$couple_min_cost',
    couple_images = '$couple_images',
    couple_includes_beaches = '$couple_includes_beaches',
    couple_includes_hill_stations = '$couple_includes_hill_stations',
    couple_includes_museums = '$couple_includes_museums',
    couple_includes_temples = '$couple_includes_temples',
    couple_includes_historical_sites = '$couple_includes_historical_sites',
    couple_includes_waterfalls = '$couple_includes_waterfalls',
    couple_includes_cultural_sites = '$couple_includes_cultural_sites',
    couple_includes_adventures = '$couple_includes_adventures',
    couple_includes_relaxation = '$couple_includes_relaxation',
    couple_includes_caves = '$couple_includes_caves',
    couple_includes_volcanoes = '$couple_includes_volcanoes',
    family_places = '$family_places',
    family_best_time = '$family_best_time',
    family_worst_months = '$family_worst_months',
    family_min_cost = '$family_min_cost',
    family_images = '$family_images',
    family_includes_beaches = '$family_includes_beaches',
    family_includes_hill_stations = '$family_includes_hill_stations',
    family_includes_museums = '$family_includes_museums',
    family_includes_temples = '$family_includes_temples',
    family_includes_historical_sites = '$family_includes_historical_sites',
    family_includes_waterfalls = '$family_includes_waterfalls',
    family_includes_cultural_sites = '$family_includes_cultural_sites',
    family_includes_adventures = '$family_includes_adventures',
    family_includes_relaxation = '$family_includes_relaxation',
    family_includes_caves = '$family_includes_caves',
    family_includes_volcanoes = '$family_includes_volcanoes',
    friends_places = '$friends_places',
    friends_best_time = '$friends_best_time',
    friends_worst_months = '$friends_worst_months',
    friends_min_cost = '$friends_min_cost',
    friends_images = '$friends_images',
    friends_includes_beaches = '$friends_includes_beaches',
    friends_includes_hill_stations = '$friends_includes_hill_stations',
    friends_includes_museums = '$friends_includes_museums',
    friends_includes_temples = '$friends_includes_temples',
    friends_includes_historical_sites = '$friends_includes_historical_sites',
    friends_includes_waterfalls = '$friends_includes_waterfalls',
    friends_includes_cultural_sites = '$friends_includes_cultural_sites',
    friends_includes_adventures = '$friends_includes_adventures',
    friends_includes_relaxation = '$friends_includes_relaxation',
    friends_includes_caves = '$friends_includes_caves',
    friends_includes_volcanoes = '$friends_includes_volcanoes',
    solo_places = '$solo_places',
    solo_best_time = '$solo_best_time',
    solo_worst_months = '$solo_worst_months',
    solo_min_cost = '$solo_min_cost',
    solo_images = '$solo_images',
    solo_includes_beaches = '$solo_includes_beaches',
    solo_includes_hill_stations = '$solo_includes_hill_stations',
    solo_includes_museums = '$solo_includes_museums',
     solo_includes_temples = '$solo_includes_temples',
    solo_includes_historical_sites = '$solo_includes_historical_sites',
    solo_includes_waterfalls = '$solo_includes_waterfalls',
    solo_includes_cultural_sites = '$solo_includes_cultural_sites',
    solo_includes_adventures = '$solo_includes_adventures',
    solo_includes_relaxation = '$solo_includes_relaxation',
    solo_includes_caves = '$solo_includes_caves',
    solo_includes_volcanoes = '$solo_includes_volcanoes'
    WHERE id = '$id'"; // Make sure the ID matches the record you want to update

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Destination updated successfully');
            window.location.href = 'adminListedCountries.php';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
