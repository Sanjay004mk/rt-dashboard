<?php
// Start the session
session_start();

// Check if the 'User' cookie is set
if (isset($_COOKIE['User'])) {
    // Redirect to user_home.php if the user is already logged in
    header("Location: user_home.php");
    exit();
}

// Database connection details
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "users";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST["email"];
    $userPassword = $_POST["password"]; // Use a different variable name for the user-entered password

    // Connect to MySQL
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a query to retrieve user details
    $stmt = $conn->prepare("SELECT UID, Name, Email, Password FROM `user details` WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($uid, $name, $dbEmail, $dbPassword);

    // Fetch the result
    $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Check if the email exists and the password is correct
    if ($email === $dbEmail && $userPassword === $dbPassword) {
        // Set the user's UID in a cookie
        $_SESSION['User'] = $uid;
        $_COOKIE['User'] = $uid;
        setcookie('User', $uid, time() + 86400 * 30);

        // Redirect to user_home.php
        header("Location: user_home.php");
        exit();
    } else {
        // Display an error message if the credentials are incorrect
        $errorMessage = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CipherSphere Construction Monitoring</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login/Signup</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content Section -->
<div class="container mt-4">
    <h1>Login to CipherSphere</h1>

    <!-- Display error message if exists -->
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <div class="input-group-append">
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
        </div>

        <!-- Login with social media buttons -->
        <div class="mb-3">
            <p>Login with:</p>
            <button type="button" class="btn btn-primary"><i class="fab fa-google"></i> Google</button>
            <button type="button" class="btn btn-primary"><i class="fab fa-facebook"></i> Facebook</button>
            <button type="button" class="btn btn-primary"><i class="fab fa-yahoo"></i> Yahoo</button>
        </div>

        <!-- Create a new account button -->
        <p>Don't have an account? <a href="signup.php">Create a new account</a></p>

        <!-- Submit button -->
        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>



<!-- Bootstrap JS and jQuery (Make sure to include Popper.js if using Bootstrap's JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<!-- Script to toggle password visibility -->
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.querySelector(".fa-eye");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
</body>
</html>
