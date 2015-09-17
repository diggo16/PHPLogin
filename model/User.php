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
    
    public function setNewInfo($username, $password, $isLoggedIn, $message) 
    {
        self::$username = $username;
        self::$password = $password;
        self::$isLoggedIn = $isLoggedIn;
        self::$message = $message;
    }
    public function isLoggedIn() 
    {
        return self::$isLoggedIn;
    }
    public function getUsername()
    {
        return self::$username;
    }
    public function getPassword()
    {
        return self::$password;
    }
    public function getMessage()
    {
        return self::$message;
    }
    public function setSessionId($id)
    {
        self::$sessionId = $id;
    }
    public function getSessionId()
    {
        return self::$sessionId;
    }
    public function setCookiePassword($password)
    {
        self::$cookiePassword = $password;
    }
    public function getCookiePassword()
    {
        return self::$cookiePassword;
    }
}
