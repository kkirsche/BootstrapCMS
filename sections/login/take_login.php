<?php
    require('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_login.php');

    $oLogin = new Login;

    echo $oLogin->verify_password("testPassword");
?>