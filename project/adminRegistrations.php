<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP
$dbname = "project";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total number of users
$sql_count = "SELECT COUNT(*) AS total_users FROM users";
$result_count = $conn->query($sql_count);
$total_users = 0;

if ($result_count && $result_count->num_rows > 0) {
    $row = $result_count->fetch_assoc();
    $total_users = $row['total_users'];
}

// Fetch all user details from the database
$sql = "SELECT id, first_name, last_name, phone, email FROM users";
$result = $conn->query($sql);

// Check if there are any users and store in array
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All User Details</title>
    <link rel="stylesheet" href="adminRegistrations.css">
</head>
<body>
    <div class="sidebar">
        <h2>Travel Admin Panel</h2>
        <button onclick="window.location.href='adminDashboard.html'">Dashboard</button>
        <button onclick="window.location.href='adminRegistrations.php'">Registered Users</button>
        <button onclick="window.location.href='adminListedCountries.php'">Listed Destinations</button>
        <button onclick="window.location.href='adminProfile.php'">Admin Profile</button>
        <button onclick="window.location.href='adminReview.php'">View Feedbacks</button>
        <button onclick="window.location.href='index.html'">Logout</button>
    </div>

    <div class="form-box">
        <h3 style="margin-left:20px">Registered Users</h3>

        <!-- Search box for filtering users -->
        <div style="margin-left:20px; margin-bottom: 10px;">
            <input type="text" id="search-input" placeholder="Search users by name..." onkeyup="filterUsers()"
                   style="padding: 10px; font-size: 1rem; border: 2px solid black; border-radius: 5px; outline: none;">
        </div>

        <?php if (!empty($users)): ?>
            <table id="userTable">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>

        <!-- Button to Show Total Users -->
        <div class="button-container">
            <br>
            <button onclick="showTotalUsers()" style="margin-left:20px;font-weight:bold;background-color:#cccccc;color:black;height:40px;">Show Total Number of Users</button>
        </div>

        <!-- Display the total number of users here -->
        <p id="totalUsersDisplay" style="display:none;margin-left:20px;">Total Number of Users: <?php echo $total_users; ?></p> <!-- Hidden initially -->
    </div>

    <script>
        function showTotalUsers() {
            var totalUsersElement = document.getElementById('totalUsersDisplay');
            totalUsersElement.style.display = 'block';
        }

        function filterUsers() {
            const input = document.getElementById('search-input').value.toLowerCase();
            const rows = document.getElementById('userTable').getElementsByTagName('tr');

            // Loop through all table rows except the header
            for (let i = 1; i < rows.length; i++) {
                const firstName = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                const lastName = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();

                if (firstName.includes(input) || lastName.includes(input)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
