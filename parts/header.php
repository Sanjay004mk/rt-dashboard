<script>
    function openNav() {
        document.getElementById("overlaynav").style.display = "flex";
    }
    function closeNav() {
        document.getElementById("overlaynav").style.display = "none";
    }
</script>

<?php
    $extras = "";
    if (isset($extra_buttons)) {
        foreach ($extra_buttons as $button) {
            $href = $button['href'];
            $class = "";
            $bname = $button['name'];
            if (isset($button['class']))
                $class = 'class="'.$button['class'].'"';
            $extras = $extras.'<a '.$class.' href="'.$href.'">'.$bname.'</a>';
        }
    }
?>

<header class="home-header">
    <a href="index.php" class="logo-group">
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