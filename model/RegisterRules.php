<?php
/**
 * Description of RegisterRules
 *
 * @author daniel
 */
class RegisterRules 
{
    private static $usernameMinLength = 3;
    private static $passwordMinLength = 6;
    private $usedUsernames;
    
    public function __construct() 
    {
        $this->usedUsernames = array();
        // TODO: add correct information to used usernames
        array_push($this->usedUsernames, "Admin");
    }
    public function checkUsernameFormat($username)
    {
        if(strlen($username) >= self::$usernameMinLength)
        {
            return true;
        }
        return false;
    }
    public function checkPasswordFormat($password)
    {
        if(strlen($password) >= self::$passwordMinLength)
        {
            return true;
        }
        return false;
    }
    public function checkUsernameAlreadyUsed($username)
    {
        if(in_array($username, $this->usedUsernames))
        {
            return true;
        }
        return false;
    }
    public function checkPasswordMatch($password, $repeatPassword)
    {
        if(strcmp($password, $repeatPassword) == 0)
        {
            return true;
        }
        return false;
    }
}
