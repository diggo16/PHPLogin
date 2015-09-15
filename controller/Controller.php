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
    private $correctUser;
    
    private $username;
    private $password;
    private static $user;
    
    /**
     * Initialize other classes
     */
    public function __construct() 
    {
        require_once 'model/LoginRules.php';
        require_once 'model/User.php';
        require_once 'view/Session.php';
        
        $this->loginRules = new LoginRules();
        self::$user = new User();
        $this->session = new Session();
        
        $username = "Admin";
        $password = "Password";
        $this->correctUser = new User();
        $id = $this->session->generateUniqueID($username, $password);
        $this->correctUser->setNewInfo($username, $password, false, "");
        $this->correctUser->setSessionId($id);
        
    }
   private function validateLogin()
   {
       $message = $this->loginRules->validateLogin($this->username, $this->password);
       return $message;
   }
   /**
    * Check if the username and password is correct,
    * else give a proper error message
    * @param String $username
    * @param String $password
    * @return User $user
    */
   public function login($username, $password) 
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
       }
       self::$user->setNewInfo($this->username, $this->password, $loggedIn, $message);
       self::$user->setSessionId($sessionId);
       return self::$user;
   }
   public function getCorrectSessionId()
   {
       return $this->correctUser->getSessionId();
   }
   public function Authenticate($username, $password)
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
       }
       self::$user->setNewInfo($this->username, $this->password, $loggedIn, $message);
       self::$user->setSessionId($sessionId);
       return self::$user;
   }
   /**
    * Log out the user
    * @param String $sessionUsername
    * @param String $sessionPassword
    */
   public function logout($sessionUsername, $sessionPassword)
   {
        // Remove session
        $this->session->removeSession($sessionUsername);
        $this->session->removeSession($sessionPassword);
        $this->session->destroySession();
   }
}
