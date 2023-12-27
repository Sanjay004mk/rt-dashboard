<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("parts/html_head.php");
?>

<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $pass = $_POST["password"];
    $uid = crc32($email);

    // Process the data or perform any necessary actions
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_if_email_exists = 'SELECT * FROM `user details` WHERE `Email` = "'.$email.'"';

    // user doesn't exsist, so create
    if ($conn->query($check_if_email_exists)->num_rows <= 0) {
        $create_user = 'INSERT INTO `user details` (`Name`, `Phone Number`, `Email`, `Password`, `UID`) VALUE ("'.$name.'", "'.$phone.'", "'.$email.'", "'.$pass.'", "'.$uid.'")';
        if ($conn->query($create_user) === FALSE) {
            $CSERROR = "<P>Failed to create account!</p>";
        }
        else
            header("Location: user_home.php");
    }
    else {
        $CSERROR = "<P>Email already exists!</p>";
    }
    
    $conn->close();
}
?>

    <?php 
        $extra_buttons = array(
            array("name"=>"Login", "href"=>"login.php", "class"=>"button")
        );
        include("parts/header.php");
    ?>

    <div class="main-content">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="register">

                <h2>Register</h2>
                <p>Please fill in this form to create an account.</p>
                <hr>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Full Name" required>
                
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="eg: 1234567890"  required>
                
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="eg: doe@jon.com" required>
                
                <label for="password">Password:</label>
                <div class="showpsw"><input type="password" id="password" name="password" placeholder="Enter new password"  required><i class="fa fa-eye" id="p-eye"></i></div>
                <!-- <div class="showpsw"><label for="password">Show Password</label><input type="checkbox" onclick="togglePassword('p')"></div> -->
                
                <label for="confirmPassword">Confirm Password:</label>
                <div class="showpsw"><input type="password" id="confirmPassword" name="confirmPassword" placeholder="Repeat password"  required><i class="fa fa-eye" id="c-eye"></i></div>
                <!-- <div class="showpsw"><label for="confirmPassword">Show Password</label><input type="checkbox" onclick="togglePassword('c')"></div> -->
               
                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

                <button type="submit" name="submit" value="submit">Signup</button>

                <p style="text-align: center">Already have an account? <a href="login.php">Login</a>.</p>

            </div>
        </form>
    </div>
        
    <?php
        include("parts/footer.php");
        include("parts/showpsw.php");
    ?>

</body>

</html>
