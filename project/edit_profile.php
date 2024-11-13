<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user with the highest ID
$sql = "SELECT * FROM Users ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the user information when Save is clicked
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_sql = "UPDATE Users SET first_name='$first_name', last_name='$last_name', phone='$phone', email='$email', password='$password' WHERE id={$user['id']}";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!');</script>";
        // Redirect to profile page
        echo "<script>window.location.href = 'profile.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #d9e4f5, #f1e3e6);
            font-family: Arial, sans-serif;
        }
        .form-box {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            width: 350px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            text-align: center;
        }
        .icons {
            position: absolute;
            top: 15px;
            left: 15px;
        }
        .icons img {
            width: 25px;
            height: 25px;
            margin: 5px;
            cursor: pointer;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            background-color: #eeeeee;
            color: #333;
            text-align: center;
        }
        button {
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #e04444;
        }
    </style>
</head>
<body>

<div class="form-box">
    <div class="icons">
        <a href="profile.php"><img src="photo/back.jpeg" alt="Back"></a>
    </div>
    <h2>Edit Profile</h2>
    <form action="edit_profile.php" method="POST">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">
        </div>
        <button type="submit">Save</button>
    </form>
</div>

</body>
</html>
