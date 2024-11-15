<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Establishing a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve parameters
$id = $_GET['id'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// Convert the start and end dates to month names
$start_month = date('F', strtotime($start_date));
$end_month = date('F', strtotime($end_date));

// Query to get worst months for the selected destination
$sql = "SELECT couple_worst_months FROM destinations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($worst_months);
$stmt->fetch();
$stmt->close();

// Split the worst months string into an array
$worstMonthsArray = array_map('trim', explode(',', $worst_months));

// Check if the selected months fall within the worst months
$isWorstMonth = in_array($start_month, $worstMonthsArray) || in_array($end_month, $worstMonthsArray);

// Return JSON response
echo json_encode(['isWorstMonth' => $isWorstMonth]);

$conn->close();
?>
