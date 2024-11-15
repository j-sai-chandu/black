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

// Fetch places with their IDs from the database
$places = [];
$sql = "SELECT id, place_name FROM destinations";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiseGlobe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Section with Navbar and Search -->
    <header>
        <div class="navbar">
            <button onclick="window.location.href='index.php'">Home</button>
            <button id="selectBtn">Select Famous Destination</button>
            <div class="search-bar-container">
                <input type="text" class="search-bar" placeholder="Search destinations..." oninput="showDropdown(this)">
                <div class="search-bar-dropdown" id="searchDropdown">
                    <?php foreach ($places as $place): ?>
                        <p data-id="<?php echo $place['id']; ?>" onclick="selectSuggestion('<?php echo htmlspecialchars($place['place_name']); ?>', <?php echo $place['id']; ?>)">
                            <?php echo htmlspecialchars($place['place_name']); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
            <button id="aboutBtn">About Us</button>
            <button id="contactBtn">Contact Us</button>
            <a href="profile.php" class="profile-icon">
                <img src="photo/profile-icon.jpg" alt="Profile Icon" class="icon">
            </a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="features">
        <div class="feature">
            <img src="photo/icon1.png" alt="Icon">
            <h3>Ultimate flexibility</h3>
            <p>You're in control, with free cancellation and payment options to satisfy any plan or budget.</p>
        </div>
        <div class="feature">
            <img src="photo/icon2.png" alt="Icon">
            <h3>Memorable experiences</h3>
            <p>Browse and book tours and activities so incredible, you'll want to tell your friends.</p>
        </div>
        <div class="feature">
            <img src="photo/icon3.png" alt="Icon">
            <h3>Quality at our core</h3>
            <p>High-quality standards. Millions of reviews. A tour company.</p>
        </div>
        <div class="feature">
            <img src="photo/icon4.png" alt="Icon">
            <h3>Award-winning support</h3>
            <p>New plan? No problem. We're here to help, 24/7.</p>
        </div>
    </section>

    <!-- Famous Destinations Section -->
    <section class="destinations" id="selectSection">
        <h2>Select any Famous Destination</h2>
        <div class="destination-list">
            <?php foreach ($places as $place): ?>
                <div class="destination" onclick="goToDateSelection(<?php echo $place['id']; ?>)">
                    <img src="photo/<?php echo strtolower($place['place_name']); ?>.png" alt="<?php echo htmlspecialchars($place['place_name']); ?>">
                    <p><?php echo htmlspecialchars($place['place_name']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer id="footer">
        <div class="contact" id="contactSection">
            <h3>Contact Us</h3>
            <p>Email: tourguide@gmail.com</p>
            <p>Address: 3-29, Gandhi Nagar, Ongole, Andhra Pradesh, India.</p>
            <p>Pin Code: 523263</p>
            <p>Mobile: +91 7319327469</p>
            <p>Telephone: +62 17-782 0021</p>
        </div>
        <div class="about" id="aboutSection">
            <h3>About Us</h3>
            <p>Welcome to Wise Globe, your ultimate travel planning companion! We're dedicated to making your travel dreams come true by simplifying the trip planning process. Whether you're a frequent flyer, a family on vacation, or a solo adventurer, we're here to guide you every step of the way.</p>
        </div>
    </footer>
    
    <!-- JavaScript for Smooth Scroll and Search Dropdown -->
    <script>
        document.getElementById("aboutBtn").addEventListener("click", function() {
            document.getElementById("aboutSection").scrollIntoView({ behavior: "smooth" });
        });

        document.getElementById("contactBtn").addEventListener("click", function() {
            document.getElementById("contactSection").scrollIntoView({ behavior: "smooth" });
        });

        document.getElementById("selectBtn").addEventListener("click", function() {
            document.getElementById("selectSection").scrollIntoView({ behavior: "smooth" });
        });

        function showDropdown(input) {
            const dropdown = document.getElementById("searchDropdown");
            dropdown.style.display = input.value.trim() ? "block" : "none";
        }

        // Hide dropdown when clicking outside of the search bar and dropdown
        document.addEventListener("click", function(event) {
            const searchBar = document.querySelector(".search-bar");
            const dropdown = document.getElementById("searchDropdown");
            if (!searchBar.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });

        function selectSuggestion(suggestion, id) {
            const searchBar = document.querySelector(".search-bar");
            searchBar.value = suggestion;
            document.getElementById("searchDropdown").style.display = "none";
            // Redirecting to dateSelected.html with the selected place ID
            window.location.href = `dateSelected.html?id=${id}`;
        }

        function goToDateSelection(id) {
            window.location.href = `dateSelected.html?id=${id}`;
        }
    </script>
</body>
</html>
