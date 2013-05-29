<?php
    class Login
    {
        //Declare variables we will use. As we don't want them used anywhere except here, they are all set to private!
        private $inputPassword;
        private $passwordHash;
        private $salt;
        private $saltChars;

        //This function verifies the user input password versus the password we have on file for them in the database.
        function verify_password($inputPassword)
        {
            $this->passwordHash = $this->better_crypt($inputPassword, 7);
            //crypt($string, $salt)
            if (crypt($inputPassword, $this->passwordHash) == $this->passwordHash)
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