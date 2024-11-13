<?php
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password']; // No hashing applied

$sql = "INSERT INTO users (first_name, last_name, phone, email, password) VALUES ('$first_name', '$last_name', '$phone', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    header("Location: login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
