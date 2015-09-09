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
    public function __construct() {
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
   public function login($username, $password) 
    {
       $this->username = $username;
       $this->password = $password;
       $message = $this->validateLogin();
       $this->loginView = new LoginView();
       $this->loginView->setInfo($this->username, $message, false);    
       $loggedIn = false;
       if($message == "")
       {
           $loggedIn = true;
       }
       self::$user->setNewInfo($username, $password, $loggedIn, $message);
       return self::$user;
   }
}
