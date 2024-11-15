<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";  // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_name = $_POST['user_name'];
$stars = $_POST['stars'];
$experience = $_POST['experience'];

// Prepare and execute SQL insert statement
$sql = "INSERT INTO reviews (user_name, stars, experience) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $user_name, $stars, $experience);

if ($stmt->execute()) {
    echo "<script>
            alert('thanks for review');
            window.location.href = '../main.php';
          </script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
