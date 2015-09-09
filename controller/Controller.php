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
        
        $this->loginRules = new LoginRules();
        self::$user = new User();
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
       if($message == "")
       {
           $loggedIn = true;
       }
       self::$user->setNewInfo($username, $password, $loggedIn, $message);
       return self::$user;
   }
}
