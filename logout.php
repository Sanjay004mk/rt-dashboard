<?php
    session_start();
    unset($_COOKIE['User']);
    unset($_SESSION['User']);
    setcookie("User", "", time()-3600);
    header("Location: login.php");
?>