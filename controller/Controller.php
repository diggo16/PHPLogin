<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Daniel
 */
class Controller 
{
    private $loginRules;
    private $loginView;
    private $session;
    private $sessionName;
    private $sessionPassword;
    private $correctUser;
    private $feedback;
    private $cookies;
    private $username;
    private $password;
    private static $user;
    
    /**
     * Initialize other classes and save the sessionName and sessionPassword
     */
    public function __construct($sessionName, $sessionPassword) 
    {
        require_once 'model/LoginRules.php';
        require_once 'model/User.php';
        require_once 'view/Session.php';
        require_once 'view/Feedback.php';
        require_once 'view/Cookies.php';
        
        // Create a correct user
        $username = "Admin";
        $password = "Password";
        $correctUser = new User();
        $this->correctUser = $correctUser;
        
        $this->loginRules = new LoginRules($correctUser);
        self::$user = new User();
        $this->session = new Session();
        
        $id = $this->session->generateUniqueID($username, $password);
        $this->correctUser->setNewInfo($username, $password, false, "");
        $this->correctUser->setSessionId($id);
        $this->sessionName = $sessionName;
        $this->sessionPassword = $sessionPassword;
        $this->feedback = new Feedback();
        $this->cookies = new Cookies();
        
    }
   private function validateLogin()
   {
       $message = "";
       if($this->loginRules->isUsernameMissing($this->username))
       {
           $message =  $this->feedback->getUsernameMissingMsg();
       }
       else if($this->loginRules->isPasswordMissing($this->password))
       {
           $message = $this->feedback->getPasswordMissingMsg();
       }
       else if(!$this->loginRules->isUsernameAndPasswordMatch($this->username, $this->password))
       {
           $message = $this->feedback->getNoMatchMsg();
       }
       return $message;
   }
   public function getCorrectSessionId()
   {
       return $this->correctUser->getSessionId();
   }
   public function authenticate($username, $password)
   {
       $this->username = $username;
       $this->password = $password;
       $message = $this->validateLogin();
       $this->loginView = new LoginView(); 
       $loggedIn = false;
       $sessionId = "";
       if($message == "")
       {
           $loggedIn = true;
           $sessionId = $this->session->generateUniqueID($this->username, $this->password);
           self::$user->setSessionId($sessionId);
           // Add session info                       
           $this->session->setSession($this->sessionName, self::$user->getUsername());
           $this->session->setSession($this->sessionPassword, self::$user->getPassword());
       }
       self::$user->setNewInfo($this->username, $this->password, $loggedIn, $message);
       
       return self::$user;
   }
   /**
    * Log out the user
    * @param String $sessionUsername
    * @param String $sessionPassword
    */
   public function logout($sessionUsername, $sessionPassword, $cookieName, $cookiePassword)
   {
        // Remove session
        $this->session->removeSession($sessionUsername);
        $this->session->removeSession($sessionPassword);
        $this->session->destroySession();
        $this->cookies->clearCookie($cookieName);
        $this->cookies->clearCookie($cookiePassword);
   }
   public function authenticateWithSavedCredentials($username, $password, $cookieName, $cookiePassword)
   {
       $this->login($username, $password);
       if(self::$user->isLoggedIn())
       {
            $cookiePass = $this->cookies->generateCookiePassword($username, $password);
            $this->cookies->setCookie($cookieName, self::$user->getUsername());
            $this->cookies->setCookie($cookiePassword, $cookiePass);
            self::$user->setCookiePassword($cookiePass);
       }
       return self::$user;     
   }
   public function authenticateCookies($cookieName, $cookiePassword)
   {
        $correctCookiePassword = $this->cookies->generateCookiePassword($this->correctUser->getUsername(), $this->correctUser->getPassword());
        if($cookieName === $this->correctUser->getUsername() && $cookiePassword === $correctCookiePassword)
        {
            return true;
        }
        return false;
   }
   private function login($username, $password)
   {
       $this->username = $username;
       $this->password = $password;
       $message = $this->validateLogin();
       $this->loginView = new LoginView(); 
       $loggedIn = false;
       $sessionId = "";
       if($message == "")
       {
           $loggedIn = true;
           $sessionId = $this->session->generateUniqueID($this->username, $this->password);
           self::$user->setSessionId($sessionId);
           // Add session info                       
           $this->session->setSession($this->sessionName, self::$user->getUsername());
           $this->session->setSession($this->sessionPassword, self::$user->getPassword());
       }
       self::$user->setNewInfo($this->username, $this->password, $loggedIn, $message);
       
       return self::$user;
   }
}
