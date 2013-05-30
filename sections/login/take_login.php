<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_user.php');

    $oLogin = new User;
    if($oLogin->verify_user($_POST['signinUsername'], $_POST['signinPassword']))
    {
        // The user is who we want! Yay! Let's setup the session for the.
        header("Location: http://localhost:8888/BootstrapCMS/index.php?signIn=1&username=" . $_POST['signinUsername']);
    }
    else
    {
        // They aren't our user...
        header("Location: http://localhost:8888/BootstrapCMS/index.php?signIn=0");
    }
?>