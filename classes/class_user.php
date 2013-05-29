<?php
    require_once('class_database.php');

    class User
    {
        private $username;
        private $password;
        private $passwordHash;
        private $passwordSalt;
        private $error;

        //This function creates a new user
        function create_user($username, $password)
        {
            $oDB = new Database;
            $this->error = false;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT username FROM users WHERE username = :username');
            $oDB->bind(':username', $username);
            $usernameCheckRow = $oDB->single();

            if (count($usernameCheckRow) == 1)
            {
                //We found a matching username. Sooo sorry!
                $this->error = true;
            }

            if ($this->error != true)
            {
                $this->username = $username;
                //Generate a unique salt for the user
                $this->passwordSalt = $this->better_crypt($password);
                //Use the unique salt to generate an encrypted password
                $this->passwordHash = crypt($password, $this->passwordSalt);

                //Prep the statement to put these into our database.
                $oDB->query("INSERT into users (username, password, salt) VALUES (:username, :password, :salt)");
                //Bind the data we want
                $oDB->bind(':username', $username);
                $oDB->bind(':password', $this->passwordHash);
                $oDB->bind(':salt', $this->passwordSalt);
                //Execute the statement
                $oDB->execute();
                //End the transaction
                $oDB->endTransaction();
            }
            else
            {
                die("The username is already taken.");
            }

        }

        //This function verifies a user's password against the one in the database
        //This function verifies the user input password versus the password we have on file for them in the database.
        function verify_password($password, $passwordSalt, $passwordHash)
        {

            //crypt($string, $salt)
            if (crypt($password, $this->passwordSalt) == $this->passwordHash)
            {
                //password is correct
                echo "Awesome";
            }
            else
            {
                //password is incorrect
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