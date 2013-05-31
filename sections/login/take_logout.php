<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_user.php');

    $oLogout = new User;
    if($oLogout->logout_user())
    {
        header("Location: http://localhost:8888/BootstrapCMS/index.php");
        exit();
    }
    else
    {
        header("Location: http://localhost:8888/BootstrapCMS/index.php");
    }
?>