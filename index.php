<?php
session_start();
// Assuming this PHP code is part of your HTML file

// Check if the 'User' cookie is set
if (isset($_COOKIE['User'])) {
    // Get the UID from the cookie
    $uid = $_COOKIE['User'];

    // Connect to MySQL (replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a query to retrieve user details
    $stmt = $conn->prepare("SELECT Name FROM `user details` WHERE UID = ?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($name);

    // Fetch the result
    $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // If user details are found, replace "Login/Signup" with the user's name
    if ($name) {
        $loggedInUser = $name;
        $redirectURL = "user_home.php";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CipherSphere - Construction Monitoring</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- CipherSphere logo -->
        <a class="navbar-brand" href="#">CipherSphere</a>

        <!-- Navbar toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <?php
                if (isset($loggedInUser)) {
                    // If user is logged in, show their name and link to user_home.php
                    echo '<li class="nav-item">
                            <a class="nav-link" href="' . $redirectURL . '">' . $loggedInUser . '</a>
                          </li>';
                } else {
                    // If user is not logged in, show Login/Signup link
                    echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Login/Signup</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Content Section -->
<div class="container mt-4">
    <h1>Welcome to CipherSphere Construction Monitoring</h1>
    <p>This platform allows you to monitor construction work efficiently.</p>
    <!-- Add more content as needed -->
</div>


<!-- Bootstrap JS and jQuery (Make sure to include Popper.js if using Bootstrap's JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
