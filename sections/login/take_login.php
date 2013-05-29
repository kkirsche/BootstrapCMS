<?php
    require('/Applications/MAMP/htdocs/cms/classes/class_login.php');

    $oLogin = new Login;

    echo $oLogin->verify_password("testPassword");
?>