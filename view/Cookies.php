<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cookies
 *
 * @author Daniel
 */
class Cookies 
{
    /*
     * Set the cookie "$cookieName" to the value "$value" 
     */
    public function setCookie($cookieName, $value) 
    {
        $expirationTime = 3600;
        setcookie($cookieName, $value, time() + $expirationTime);
    }
    /*
     * Return the cookie "$cookieName"
     */
    public function getCookie($cookieName) 
    {
        return filter_input(INPUT_COOKIE, $cookieName, FILTER_SANITIZE_STRING);
    }
    /*
     * Clear the cookie "$cookieName"
     */
    public function clearCookie($cookieName)
    {
        setcookie($cookieName,"",time()-1);
    }
    public function generateCookiePassword($username, $password)
    {
        $id = $username . "::" . $password;
        return sha1($id);  
    }
    // TODO create a random password
}
