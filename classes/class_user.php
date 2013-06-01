<?php
    require_once('class_database.php');
    require_once('class_google2FA.php');

    class User
    {
        private $username;
        private $password;
        private $passwordHash;
        private $passwordSalt;
        private $error;
        private $numberOfResults;
        private $oTwoFactorAuth;
        private $initKey;
        private $QRCode;

        //This function creates a new user
        function create_user($username, $password)
        {
            $oDB = new Database;
            $this->error = false;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT username FROM users WHERE username = :username');
            $oDB->bind(':username', $username);
            $usernameCheckRow = $oDB->single();

            if (isset($usernameCheckRow['username']))
            {
                //The username is already taken
                $this->error = true;
            }

            if ($this->error != true)
            {
                $this->username = $username;
                //Encrypt the password
                $this->passwordHash = $this->better_crypt($password, 7);

                $oTFA = new Google2FA;
                //first we need our secret
                $this->initKey = $oTFA->generate_secret_key();

                //next let's make that a secret key
                $secretKey = $oTFA->base32_decode($this->initKey);

                //Begin the transaction
                $oDB->beginTransaction();
                //Prep the statement to put these into our database.
                $oDB->query("INSERT into users (username, password, TFA_initKey, TFA_secretKey) VALUES (:username, :password, :initKey, :secretKey)");
                //Bind the data we want
                $oDB->bind(':username', $username);
                $oDB->bind(':password', $this->passwordHash);
                $oDB->bind(':initKey', $this->initKey);
                $oDB->bind(':secretKey', $secretKey);
                //Execute the statement
                $oDB->execute();
                //End the transaction
                $oDB->endTransaction();

                return true;
            }
            else
            {
                return false;
            }
        }

        function getQRCode_For_twoFactorAuthentication($userID)
        {
            session_start();
            $oTFA = new Google2FA;
            $oDB = new Database;

            $oDB->query('SELECT TFA_initKey FROM users WHERE id = :userID');
            $oDB->bind(':userID', $userID);
            $userInfo = $oDB->single();

            if (isset($userInfo['TFA_initKey']))
            {
                $QRCode = $oTFA->getQRCodeGoogleUrl($userInfo['TFA_initKey']);
                echo '<img src="' . $QRCode . '" alt="QRCode" />';
            }
        }

        function get_userID($username)
        {
            $oDB = new Database;
            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT id FROM users WHERE username = :username');
            $oDB->bind(':username', $username);
            $usernameCheckRow = $oDB->single();

            if (isset($usernameCheckRow['id']))
            {
                return $usernameCheckRow['id'];
            }
            else
            {
                return false;
            }
        }

        function verify_user($username, $password)
        {
            $oDB = new Database;
            $this->error = true;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT username, password FROM users WHERE username = :username');
            $oDB->bind(':username', $username);
            $usernameCheckRow = $oDB->single();

            if (isset($usernameCheckRow['username']) && isset($usernameCheckRow['password']))
            {
                if ($this->verify_password($password, $usernameCheckRow['password']))
                {
                    $this->error = false;
                }
                else
                {
                    $this->error = true;
                }
            }
            else
            {
                $this->error = true;
            }

            switch($this->error)
            {
                case true:
                    //there was an error, return false
                    return false;
                    break;
                case false:
                    //No errors, let's go!
                    return true;
                    break;
                default:
                    //who knows...let's go with false in case something was wrong
                    return false;
            }
        }

        //Log the user out of our application.
        function logout_user()
        {
            session_start();
            session_destroy();

            return true;
        }

        //This function verifies a user's password against the one in the database
        //This function verifies the user input password versus the password we have on file for them in the database.
        function verify_password($password, $passwordHash)
        {
            //crypt($string, $salt) —- Note, we are letting blowfish determine the key from hash. It's smart enough to do that :)
            if (crypt($password, $passwordHash) == $passwordHash)
            {
                //password is correct
                return true;
            }
            else
            {
                //password is incorrect
                return false;
            }
        }

        //This function improves upon the basic crypt function provided by PHP.
        function better_crypt($userInputPassword, $rounds)
        {
            $this->salt = "";
            $this->saltChars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
            for ($i = 0; $i < 22; $i++)
            {
                $this->salt .= $this->saltChars[array_rand($this->saltChars)];
            }
            return crypt($userInputPassword, sprintf('$2a$%02d$', $rounds) . $this->salt);
        }
    }
?>