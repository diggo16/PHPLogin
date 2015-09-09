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
    private $dateTimeView;
    private $layoutView;
    
    private $username;
    private $password;
    private $loginButton;
    private $logoutButton;
    public function __construct() {
        require_once 'model/LoginRules.php';
        
        $this->loginRules = new LoginRules();
    }
   private function validateLogin()
   {
       $usernameMessage = $this->loginRules->validateUsername($this->username);
       $passwordMessage = $this->loginRules->validatePassword($this->password);
       $message = $this->loginRules->getCorrectMessage($usernameMessage, $passwordMessage);
       return $message;
   }
   public function login($username, $password) 
    {
       $this->username = $username;
       $this->password = $password;
       $message = $this->validateLogin();
       $this->loginView = new LoginView();
       $this->loginView->setInfo($this->username, $message, false);
   }
}
