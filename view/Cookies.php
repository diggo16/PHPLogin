<?php
/**
 * Class that handles cookies
 *
 * @author Daniel
 */
class Cookies 
{
    /**
     * Set the cookie "$cookieName" to the value "$value" 
     * @param string $cookieName
     * @param string $value
     */
    public function setCookie($cookieName, $value) 
    {
        $expirationTime = 3600;
        setcookie($cookieName, $value, time() + $expirationTime);
    }
    /**
     * Return the cookie "$cookieName"
     * @param string $cookieName
     * @return string $cookieName
     */
    public function getCookie($cookieName) 
    {
        return filter_input(INPUT_COOKIE, $cookieName, FILTER_SANITIZE_STRING);
    }
    /**
     * Clear the cookie "$cookieName"
     * @param string $cookieName
     */
    public function clearCookie($cookieName)
    {
        setcookie($cookieName,"",time()-1);
    }
    /**
     * Generate a secure String 
     * that becomes a cookie password
     * @param string $username
     * @param string $password
     * @return string cookiePassword
     */
    public function generateCookiePassword($username, $password)
    {
        $id = $username . "::" . $password;
        return sha1($id);    // sha1 = secure hash algorithm
    }
}
