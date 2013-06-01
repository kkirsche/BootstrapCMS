<div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <?php
                if (isset($_GET['signIn']))
                {
                    if ($_GET['signIn'] == 0)
                    {
                    ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>D&rsquo;oh!</strong> The username or password was wrong.
                    </div>
                <?php
                    }
                    else if (isset($_SESSION['userID']) && isset($_SESSION['username']))
                    {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Welcome <?php echo $_GET['username']; ?>!</strong> You have been logged in.
                    </div>
                    <?php
                    }
                }
               ?>
            <div class="hero-unit">
                <h1>Welcome!</h1>
                <p>The goal of BootstrapCMS is to build a basic working content management system built around Twitter Bootstrap. This is primarily for personal learning purposes, as I look to better understand how content management systems fucntion.</p>
                <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
            </div>

            <!-- Example row of columns -->
            <div class="row">
                <div class="span4">
                    <h2>&Uuml;ber Secure</h2>
                    <p>One of the main goals of this project, aside from basic learning, was to ensure that the design and implementation of all code was safe and secure. For this reason, passwords are securely encrypted using Blowfish, which prevents the password for being decrypted. For this reason, you can be sure that the passwords used with this system, even if leaked online, will be safe and secure.</p>
                    <p><a class="btn" href="#">View details &raquo;</a></p>
                </div>
                <div class="span4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn" href="#">View details &raquo;</a></p>
               </div>
                <div class="span4">
                    <?php
                    if (isset($_GET['createUser']))
                    {
                        if ($_GET['createUser'] == 1)
                        {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> We&rsquo;ve created a user named <?php echo $_GET['username']; ?>
                        </div>
                        <?php
                        }
                        else if ($_GET['createUser'] == 0)
                        {
                        ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>D&rsquo;oh!</strong> The username <?php echo $_GET['username']; ?> is already taken!
                        </div>
                        <?php
                        }
                        else if ($_GET['createUser'] == 2)
                        {
                        ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>D&rsquo;oh!</strong> Enter a username!
                        </div>
                        <?php
                        }
                        else if ($_GET['createUser'] == 3)
                        {
                        ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>D&rsquo;oh!</strong> Enter a password!
                        </div>
                        <?php
                        }
                    }
                    ?>
                    <h2>Register Now!</h2>
                    <form name="register" action="sections/register/take_register.php" method="POST">
                        <div class="control-group">
                            <label class="control-label" for="inputUsername">Username</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputUsername" name="registerUsername" placeholder="Username" required>
                            </div>
                        </div>
                      <div class="control-group">
                        <label class="control-label" for="inputPassword">Password</label>
                        <div class="controls">
                          <input type="password" class="span4" id="inputPassword" name="registerPassword" placeholder="Password" required>
                        </div>
                      </div>
                      <div class="control-group">
                        <div class="controls">
                          <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>