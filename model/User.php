<?php
/**
 * User with information
 *
 * @author Daniel
 */
class User 
{
    private $username;
    private $password;
    private $isLoggedIn;
    private $message;
    private $sessionId;
    private $cookiePassword;
    
    /**
     * 
     * @param string $username
     * @param string $password
     * @param boolean $isLoggedIn
     * @param string $message
     */
    public function setNewInfo($username, $password, $isLoggedIn, $message) 
    {
        $this->username = $username;
        $this->password = $password;
        $this->isLoggedIn = $isLoggedIn;
        $this->message = $message;
    }
    /**
     * Check if the user is logged in
     * @return boolean
     */
    public function isLoggedIn() 
    {
        return $this->isLoggedIn;
    }
    /**
     * Return the username
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Return the password
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Return the message
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * Set the session id
     * @param string $id
     */
    public function setSessionId($id)
    {
        $this->sessionId = $id;
    }
    /**
     * Return the session id
     * @return string $sessionId
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
    /**
     * Set the cookie password
     * @param string $password
     */
    public function setCookiePassword($password)
    {
        $this->cookiePassword = $password;
    }
    /**
     * Return the cookie password
     * @return string $cookiePassword
     */
    public function getCookiePassword()
    {
        return $this->cookiePassword;
    }
    /**
     * Log in the user
     */
    public function login()
    {
        $this->isLoggedIn = true;
    }
    public function logout()
    {
        $this->isLoggedIn = false;
    }
}
