<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_user.php');

    $oLogin = new User;
    echo $oLogin->verify_user($_POST['signinUsername'], $_POST['signinPassword']);
?>