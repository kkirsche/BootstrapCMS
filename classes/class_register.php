<?php
    require_once('class_database.php');

    class Register
    {
        private $username;
        private $password;
        private $passwordHash;
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

            if ($usernameCheckRow == 1)
            {
                //We found a matching username. Sooo sorry!
                $this->error = true;
            }

            if ($this->error != true)
            {
                $this->username =
                $this->passwordHash = $this->better_crypt($password);
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