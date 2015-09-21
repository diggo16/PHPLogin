<?php
/**
 * Description of User
 *
 * @author Daniel
 */
class User 
{
    private static $username;
    private static $password;
    private static $isLoggedIn;
    private static $message;
    private static $sessionId;
    private static $cookiePassword;
    /**
     * Set the most important info of the user
     * @param type $username
     * @param type $password
     * @param type $isLoggedIn
     * @param type $message
     */
    public function setNewInfo($username, $password, $isLoggedIn, $message) 
    {
        self::$username = $username;
        self::$password = $password;
        self::$isLoggedIn = $isLoggedIn;
        self::$message = $message;
    }
    /**
     * Check if the user is logged in
     * @return Boolean $isLoggedIn
     */
    public function isLoggedIn() 
    {
        return self::$isLoggedIn;
    }
    /**
     * Return the username
     * @return String $username
     */
    public function getUsername()
    {
        return self::$username;
    }
    /**
     * Return the password
     * @return String $password
     */
    public function getPassword()
    {
        return self::$password;
    }
    /**
     * Return the message
     * @return String $message
     */
    public function getMessage()
    {
        return self::$message;
    }
    /**
     * Set the session id
     * @param type $id
     */
    public function setSessionId($id)
    {
        self::$sessionId = $id;
    }
    /**
     * Return the session id
     * @return String $sessionId
     */
    public function getSessionId()
    {
        return self::$sessionId;
    }
    /**
     * Set the cookie password to $password
     * @param String $password
     */
    public function setCookiePassword($password)
    {
        self::$cookiePassword = $password;
    }
    /**
     * Return the cookie password
     * @return String $cookiePassword
     */
    public function getCookiePassword()
    {
        return self::$cookiePassword;
    }
    /*
     * Log in the user
     */
    public function login()
    {
        self::$isLoggedIn = true;
    }
}
