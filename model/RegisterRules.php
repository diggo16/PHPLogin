<?php
/**
 * rules for registration
 *
 * @author daniel
 */
class RegisterRules 
{
    private static $usernameMinLength = 3;      // minimum username length
    private static $passwordMinLength = 6;      // minimum password length
    private $usedUsernames;                     // All the used usernames
    /**
     * Initialize and collect the used usernames
     */
    public function __construct() 
    {
        $this->usedUsernames = array();
        // TODO: add correct information to used usernames
        array_push($this->usedUsernames, "Admin");
    }
    /**
     * Check if the username is longer or equal than $usernameMinLength
     * @param var $username
     * @return boolean
     */
    public function checkUsernameFormat($username)
    {
        //TODO refactor checkUsernameFormat and checkPasswordFormat
        if(strlen($username) >= self::$usernameMinLength)
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the password is longer or equal than $passwordMinLength
     * @param var $password
     * @return boolean
     */
    public function checkPasswordFormat($password)
    {
        if(strlen($password) >= self::$passwordMinLength)
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the username is already used
     * @param var $username
     * @return boolean
     */
    public function checkUsernameAlreadyUsed($username)
    {
        // if the array contains the username
        if(in_array($username, $this->usedUsernames))
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the passwords are equal
     * @param var $password
     * @param var $repeatPassword
     * @return boolean
     */
    public function checkPasswordMatch($password, $repeatPassword)
    {
        if(strcmp($password, $repeatPassword) == 0)
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the username contains illegal characters
     * @param var $username
     * @return boolean
     */
    public function isUsernameValid($username)
    {
        if (preg_match('/[\'^Â£$%&*()}{@#~?><>,|=_+Â¬-]/', $username))
        {
            return false;
        }
        return true;
    }
}
