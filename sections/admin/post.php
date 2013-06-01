<?php
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_menu.php');
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/classes/class_page.php');
    require_once('/Applications/MAMP/htdocs/BootstrapCMS/config.php');
    session_start();
    $oMenu = new Menu;
    $oPage = new Page;

    if (isset($_SESSION['username']))
    {
        require_once('/Applications/MAMP/htdocs/BootstrapCMS/sections/header/header_Private.php');
    }
    else
    {
        require_once('/Applications/MAMP/htdocs/BootstrapCMS/sections/header/header_Public.php');
    }
    ?>
        <div class="container">

            <?php
                if (isset($_SESSION['username']))
                {
                    //User is logged in
                    if (isset($_GET['id']))
                    {
                        echo $oPage->get_admin_page($_GET['id']);
                    }
                    else
                    {
                        echo $oPage->get_admin_page(1);
                    }
                }
                else
                {
                    require_once('/Applications/MAMP/htdocs/BootstrapCMS/sections/homepage/homepage_public.php');
                }
            ?>

            <hr>

            <footer>
                <p>&copy; Kevin Kirsche 2013</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>