<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("parts/html_head.php");
?>

<body>

    <?php 
        $extra_buttons = array(
            array("name"=>"Login", "href"=>"login.php", "class"=>"button"),
            array("name"=>"Sign up", "href"=>"signup.php", "class"=>"button")
        );
        include("parts/header.php");
    ?>

    <div class="main-content">
        <p>This is the main content.</p>
    </div>

    <?php
        include("parts/footer.php");
    ?>

</body>

</html>
