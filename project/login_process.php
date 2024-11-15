<?php
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);
$m = "Invalid credentials! Please enter the correct details.";

if ($result->num_rows > 0) {
    header("Location: main.php");
    exit;
} else {
    echo "<script type='text/javascript'>
        alert('$m');
        window.location.href = 'login.html';
    </script>";
}

$conn->close();
?>
