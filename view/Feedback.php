<?php
/**
 * Contains feedback messages that are available through get methods.
 *
 * @author Daniel
 */
class Feedback 
{
     /**
     * Return welcome message
     * @return string welcomeString
     */
    public function getWelcomeMsg()
    {
        return "Welcome";
    }
    /**
     * Return bye message
     * @return string byeString
     */
    public function getByeMsg() 
    {
       return "Bye bye!";
    }
        /**
     * Return username is missing message
     * @return string usernameMissingString
     */
    public function getUsernameMissingMsg()
    {
        return "Username is missing";
    }
    /**
     * Return password is missing message
     * @return string passwordMissingString
     */
    public function getPasswordMissingMsg()
    {
        return "Password is missing";
    }
        /**
     * Return no match message
     * @return string noMatchString
     */
    public function getNoMatchMsg() 
    {
        return "Wrong name or password";
    }
    /**
     * Return welcome with cookie message
     * @return string welcomeCookieString
     */
    public function getWelcomeCookieMsg()
    {
        return "Welcome back with cookie";
    }
    /**
     * Return wrong information from cookies message
     * @return string wrongInfoCookieString
     */
    public function getWrongInformationCookies()
    {
        return "Wrong information in cookies";
    }
    /**
     * Return welcome and remembered message
     * @return string welcomeAndRemembered
     */
    public function getWelcomeAndRemembered()
    {
        return "Welcome and you will be remembered";
    }
    public function getUsernameTooShortMsg()
    {
        return "Username has too few characters, at least 3 characters.";
    }
    public function getPasswordTooShortMsg()
    {
        return "Password has too few characters, at least 6 characters.";
    }
    public function getUsernameAlreayExists() 
    {
        return "User exists, pick another username.";
    }
    public function getPasswordsDontMatch()
    {
        return "Passwords do not match. User exists, pick another username.";
    }
    public function getUsernameIsInvalidMsg()
    {
        return "Username contains invalid characters.";
    }
    public function getSucessfulRegistration()
    {
        return "Registered new user";
    }
}
