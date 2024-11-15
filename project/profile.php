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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
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
        .logout-icon {
            position: absolute;
            bottom: 15px;
            left: 15px;
        }
        .icons img, .logout-icon img {
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
        .form-group p {
            background-color: #aaa;
            border-radius: 10px;
            padding: 10px;
            color: #ffffff;
            font-size: 16px;
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
            margin-top: 20px;
        }
        button:hover {
            background-color: #e04444;
        }
        .sai{
            text-align:left;
        }
        .button{
            align:right;
        }
    </style>
</head>
<body>

<div class="form-box">
    <div class="icons">
        <a href="main.php"><img src="photo/back.jpeg" alt="Back"></a>
    </div>
    <div class="logout-icon">
        <a href="index.html"><img src="photo/logout.png" alt="Logout"></a>
    </div>
    <h2>Profile</h2>
    <div class="sai">
    <div class="form-group">
        <label>First Name</label>
        <p><?php echo htmlspecialchars($user['first_name']); ?></p>
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <p><?php echo htmlspecialchars($user['last_name']); ?></p>
    </div>
    <div class="form-group">
        <label>Phone</label>
        <p><?php echo htmlspecialchars($user['phone']); ?></p>
    </div>
    <div class="form-group">
        <label>Email</label>
        <p><?php echo htmlspecialchars($user['email']); ?></p>
    </div>
    <div class="form-group">
        <label>Password</label>
        <p><?php echo htmlspecialchars($user['password']); ?></p>
    </div>
    </div>
    <div class="button1">
    <button onclick="window.location.href='edit_profile.php'">Edit</button>
    </div>
</div>

</body>
</html>
