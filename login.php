<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<?php
    $page_title = "Login";
    include("parts/html_head.php");
?>

<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Login"])) {
    // Replace these variables with your actual database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // User to check (replace 'username_to_check' with the actual username)
    $userToCheck = $_POST["email"];
    $passToCheck = $_POST["password"];

    // SQL query to check if the user exists
    $sql = "SELECT * FROM `user details` WHERE `Email` = '$userToCheck'";
    
    // Execute the query
    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $details = $result->fetch_assoc();
        if ($details["Password"] != $passToCheck)
            $LoginError = "Incorrect Password.";
        else{
            $conn->close();            
            header("Location: user_home.php");        
        }
    } else {
        $LoginError = "Email doesn't exist.";
    }
    
    // Close the connection
    $conn->close();
}
?>

    <?php 
        $extra_buttons = array(
            array("name"=>"Sign up", "href"=>"signup.php", "class"=>"button")
        );
        include("parts/header.php");
    ?>

    <div class="main-content">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div class="login">
                <h2>Login with Social Media or Manually</h2>
                <div class="sb-default-container">
                    <div class="social-btn">   
                        <a href="#" class="fb">
                            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                        </a>
                        <a href="#" class="twitter">
                            <i class="fa fa-twitter fa-fw"></i> Login with Twitter
                        </a>
                        <a href="#" class="google">
                            <i class="fa fa-google fa-fw"></i> Login with Google
                        </a>
                    </div>

                    <span class="vl-innertext">or</span>                                      
                    
                    <div class="user-pass-ip">                        
                        <input type="text" name="email" placeholder="Email" required>
                        <div class="showpsw"><input type="password" name="password" id="password" placeholder="Password" required><i class="fa fa-eye" id="p-eye" style="top: 28%;"></i></div>
                        <!-- <div class="showpsw" style="padding: 0; margin: 0;"><label for="password" style="padding: 0; margin: 0;">Show Password</label><input type="checkbox" style="padding-top:0; margin-top: 5px;" onclick="togglePassword('p')"></div> -->
                        <?php
                            if (isset($LoginError)) {
                                echo "<div class='error-text'>$LoginError</div>";
                            }
                        ?>
                        <input type="submit" name="Login" value="Login">
                    </div>
                    
                </div>
                <div class="bottom-buttons">
                    <a href="signup.php" >Sign up</a>
                    <a href="#" >Forgot password?</a>
                </div>
            </div>
        </form>

        
    </div>

    <?php
        include("parts/footer.php");
        include("parts/showpsw.php");
    ?>

</body>

</html>
