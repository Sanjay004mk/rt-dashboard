<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php    
        if (!isset($page_title))
            $page_title = "CipherSphere";
        
        echo $page_title;
    ?>
    </title>
    <link rel="icon" type="image/svg" href="
    <?php
        if (!isset($page_logo))
            $page_logo = 'logo.svg';

        echo $page_logo;
    ?>
    ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<?php
    if (!isset($GLOBALS['userdb']) || !isset($GLOBALS['prjdb'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";

        $GLOBALS['userdb'] = new mysqli($servername, $username, $password, "users");
        if ($GLOBALS['userdb']->connect_error) {
            die("Connection failed: " . $GLOBALS['userdb']->connect_error);
        }
        $GLOBALS['prjdb'] = new mysqli($servername, $username, $password, "construction_projects");
        if ($GLOBALS['prjdb']->connect_error) {
            die("Connection failed: " . $GLOBALS['prjdb']->connect_error);
        }
    }

?>
