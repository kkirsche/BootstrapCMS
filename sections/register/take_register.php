<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_user.php');

    if (isset($_POST['registerUsername']) && isset($_POST['registerPassword']))
    {
        //Create our user object
        $oRegister = new User;

        //Let's make our user
        if ($oRegister->create_user($_POST['registerUsername'], $_POST['registerPassword']))
        {
            header("Location: http://localhost:8888/BootstrapCMS/index.php?createUser=1&username=" . $_POST['registerUsername']);
        }
    }
?>