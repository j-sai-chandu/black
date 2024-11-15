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

// Fetch all admin details from the database
$sql = "SELECT id, first_name, last_name, phone, email, password FROM admin";
$result = $conn->query($sql);

// Check if there are any admins and store them in an array
$admins = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="adminRegistrations.css">
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 10px 10px 10px 10px;
            font-size: 18px;
            text-align: left;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 16px;
        }
        table th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .edit-button, .save-button, .delete-button, .add-button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .edit-button {
            background-color: #4CAF50;
            color: white;
        }
        .save-button {
            background-color: #008CBA;
            color: white;
            display: none; /* Initially hidden */
        }
        .delete-button {
            background-color: #f44336;
            color: white;
        }
        .add-button {
            background-color: #4CAF50;
            color: white;
            margin: 10px auto;
            display: block;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Travel Admin Panel</h2>
        <button onclick="window.location.href='adminDashboard.html'">Dashboard</button>
        <button onclick="window.location.href='adminRegistrations.php'">Registered Users</button>
        <button onclick="window.location.href='adminListedCountries.php'">Listed Destinations</button>
        <button onclick="window.location.href='adminProfile.php'">Admin Profile</button>
        <button onclick="window.location.href='adminReview.php'">View Feedbacks</button>
        <button onclick="window.location.href='index.html'">Logout</button>
    </div>

    <!-- Main Content -->
    <div class="form-box">
        <h3 style="text-align: center;">Admin Profile</h3>

        <!-- Admin Table -->
        <table id="adminTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr data-id="<?php echo $admin['id']; ?>">
                        <td class="editable"><?php echo htmlspecialchars($admin['first_name']); ?></td>
                        <td class="editable"><?php echo htmlspecialchars($admin['last_name']); ?></td>
                        <td class="editable"><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td class="editable"><?php echo htmlspecialchars($admin['phone']); ?></td>
                        <td class="editable"><?php echo htmlspecialchars($admin['password']); ?></td>
                        <td class="action-buttons">
                            <button class="edit-button" onclick="editRow(this)">Edit</button>
                            <button class="save-button" onclick="saveRow(this)">Save</button>
                            <button class="delete-button" onclick="deleteRow(this)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Add Row -->
                <tr>
                    <td><input type="text" placeholder="First Name"></td>
                    <td><input type="text" placeholder="Last Name"></td>
                    <td><input type="text" placeholder="Email"></td>
                    <td><input type="text" placeholder="Phone"></td>
                    <td><input type="text" placeholder="Password"></td>
                    <td class="action-buttons">
                        <button class="add-button" onclick="addRow(this)">Add</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        // Enable editing for the selected row
        function editRow(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('.editable');
            cells.forEach(cell => {
                const currentValue = cell.textContent.trim();
                cell.innerHTML = `<input type="text" value="${currentValue}" style="width: 100%; padding: 5px;">`;
            });
            button.style.display = 'none'; // Hide "Edit" button
            row.querySelector('.save-button').style.display = 'inline-block'; // Show "Save" button
        }

        // Save the edited data to the database
        function saveRow(button) {
            const row = button.closest('tr');
            const id = row.getAttribute('data-id');
            const cells = row.querySelectorAll('.editable');
            const data = {};

            // Collect data from input fields
            cells.forEach((cell, index) => {
                const input = cell.querySelector('input');
                if (input) {
                    data[index] = input.value.trim();
                    cell.textContent = input.value.trim(); // Replace input with updated text
                }
            });

            button.style.display = 'none'; // Hide "Save" button
            row.querySelector('.edit-button').style.display = 'inline-block'; // Show "Edit" button

            // Send updated data to the server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'updateAdmin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Admin updated successfully.');
                } else {
                    alert('Failed to update admin.');
                }
            };
            xhr.send(`id=${id}&first_name=${encodeURIComponent(data[0])}&last_name=${encodeURIComponent(data[1])}&email=${encodeURIComponent(data[2])}&phone=${encodeURIComponent(data[3])}&password=${encodeURIComponent(data[4])}`);
        }

        // Delete a row from the table and database
        function deleteRow(button) {
            if (confirm('Are you sure you want to delete this admin?')) {
                const row = button.closest('tr');
                const id = row.getAttribute('data-id');

                // Send delete request to the server
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'deleteAdmin.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        row.remove(); // Remove the row from the table
                        alert('Admin deleted successfully.');
                    } else {
                        alert('Failed to delete admin.');
                    }
                };
                xhr.send(`id=${id}`);
            }
        }

        // Add a new admin row to the database and table
        function addRow(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input');
            const data = Array.from(inputs).map(input => input.value.trim());

            // Send new admin data to the server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'addAdmin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Reload the page to see the new admin
                    location.reload();
                } else {
                    alert('Failed to add admin.');
                }
            };
            xhr.send(`first_name=${encodeURIComponent(data[0])}&last_name=${encodeURIComponent(data[1])}&email=${encodeURIComponent(data[2])}&phone=${encodeURIComponent(data[3])}&password=${encodeURIComponent(data[4])}`);
        }
    </script>
</body>
</html>
