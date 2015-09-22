<?php
/**
 * User with information
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
     * 
     * @param string $username
     * @param string $password
     * @param boolean $isLoggedIn
     * @param string $message
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
     * @return boolean
     */
    public function isLoggedIn() 
    {
        return self::$isLoggedIn;
    }
    /**
     * Return the username
     * @return string $username
     */
    public function getUsername()
    {
        return self::$username;
    }
    /**
     * Return the password
     * @return string $password
     */
    public function getPassword()
    {
        return self::$password;
    }
    /**
     * Return the message
     * @return string $message
     */
    public function getMessage()
    {
        return self::$message;
    }
    /**
     * Set the session id
     * @param string $id
     */
    public function setSessionId($id)
    {
        self::$sessionId = $id;
    }
    /**
     * Return the session id
     * @return string $sessionId
     */
    public function getSessionId()
    {
        return self::$sessionId;
    }
    /**
     * Set the cookie password
     * @param string $password
     */
    public function setCookiePassword($password)
    {
        self::$cookiePassword = $password;
    }
    /**
     * Return the cookie password
     * @return string $cookiePassword
     */
    public function getCookiePassword()
    {
        return self::$cookiePassword;
    }
    /**
     * Log in the user
     */
    public function login()
    {
        self::$isLoggedIn = true;
    }
    public function logout()
    {
        self::$isLoggedIn = false;
    }
}
