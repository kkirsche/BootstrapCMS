<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_page.php');
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/config.php');
    if (isset($_POST['newPageTitle']) && isset($_POST['newPageContent']))
    {
        $oPage = new Page;
        if ($oPage->insert_page($_POST['newPageTitle'], $_POST['newPageContent']))
        {
            header("Location:  http://localhost:8888/BootstrapCMS/index.php");
        }
    }
    else
    {
        die("You can't access this page directly.");
    }

?>