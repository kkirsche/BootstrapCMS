<?php
    require_once("classes/class_user.php");
    $user = new User;
    $user->getQRCode_For_twoFactorAuthentication(6);

?>