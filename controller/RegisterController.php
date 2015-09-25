<?php
/**
 * Description of RegisterController
 *
 * @author daniel
 */
class RegisterController 
{
    private static $usernameArray;
    public function __construct() 
    {
        require_once ("model/User.php");
        self::$usernameArray = [];
        $correctUser = new User();
        $correctUser->setNewInfo("Admin", "Password", false, "");
        self::$usernameArray[] = $correctUser;
    }
    public function registerUser($username, $password, $repeatPassword) 
    {
        $message = $this->checkUsername($username);
        $message .=$this->checkPassword($password);
        $message .= $this->checkRepeatPassword($password, $repeatPassword);
        return $message;
    }
    private function checkUsername($username)
    {
        $message = "";
        if(strlen($username) < 3)
        {
            throw new Exception("Username too short");
        }
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
        {
            throw new Exception("Illegal characters");
        }
        foreach (self::$usernameArray as $correctUser) 
        {
            if(strcmp($correctUser->getUsername(), $username) === 0)
            {
                throw new Exception("Username already exist");
            }
        }
        return $message;
    }
    private function checkPassword($password)
    {
        $message = "";
        $message = $password;
        return $message;
    }
    private function checkRepeatPassword($password, $repeatPassword)
    {
        $message = "";
        $message = $repeatPassword;
        return $message;
    }
}
