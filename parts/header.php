<script>
    function openNav() {
        document.getElementById("overlaynav").style.display = "flex";
    }
    function closeNav() {
        document.getElementById("overlaynav").style.display = "none";
    }
    function clearLogin() {
        document.cookie = 'User=; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
</script>




<?php
    $extras = "";
    if (isset($islogout)) {
        $extras = '<a class="button" href="login.php" onclick="clearLogin()">Logout</a>';
    }
    else if (isset($_COOKIE['User'])) {
        $uid = $_COOKIE['User'];

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

        $get_email = 'SELECT * FROM `user details` WHERE `UID` = "'.$uid.'"';
        $result = $conn->query($get_email);
        // user doesn't exsist, so create
        if ($result->num_rows <= 0) {
           $name = "NULL";
        }
        else {
            $det = $result->fetch_assoc();
            $name = $det['Name'];
        }
        
        $conn->close();
        $extras = '<a class="button" href="user_home.php">'.$name.'</a>';
    }
    else if (isset($extra_buttons)) {
        foreach ($extra_buttons as $button) {
            $href = $button['href'];
            $class = "";
            $bname = $button['name'];
            if (isset($button['class']))
                $class = 'class="'.$button['class'].'"';
            $extras = $extras.'<a '.$class.' href="'.$href.'">'.$bname.'</a>';
        }
    }
    if (!isset($home))
        $home = "index.php";
    
?>

<header class="home-header">
    <a href="<?php echo $home; ?>" class="logo-group">
        <!-- <img src="logo.svg" alt="Logo" width=50 height=50> -->
        <div class="website-title">CipherSphere</div>
    </a>

    <div class="right-aligned-nav-bar">
        <a href="index.php">Home</a>
        <a href="index.php">About</a>
        <a href="index.php">Contact</a>
        <?php echo $extras ?>
    </div>

    <a href="javascript:void(0);" class="icon" onclick="openNav()">
        <i class="fa fa-bars"></i>
    </a>
</header>    

<div class="overlay-nav" id="overlaynav">
    <a href="javascript:void(0)" class="close-button" onclick="closeNav()">&times;</a>

    <a href="index.php">Home</a>
    <a href="index.php">About</a>
    <a href="index.php">Contact</a>
    <?php echo $extras ?>
</div>