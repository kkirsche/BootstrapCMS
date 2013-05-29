<?php
    class Login
    {

        private $inputPassword;
        private $passwordHash;
        private $salt;
        private $saltChars;

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

        //
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