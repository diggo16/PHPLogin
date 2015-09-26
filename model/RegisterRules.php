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
    
    public function __construct() 
    {
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
}
