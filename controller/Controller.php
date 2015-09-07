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
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        
        $this->loginRules = new LoginRules();
    }
   public function validateLogin()
   {
       $usernameMessage = $this->loginRules->validateUsername($this->username);
       $passwordMessage = $this->loginRules->validatePassword($this->password);
       $message = $this->loginRules->getCorrectMessage($usernameMessage,  $this->username, $passwordMessage, $this->password);
       return $message;
   }
   public function start()
   {
       $message = "";
       $this->dateTimeView = new DateTimeView();
        $this->layoutView = new LayoutView();
     
        $this->loginView = new LoginView();
        $this->username = $this->loginView->getUsername();
        $this->password = $this->loginView->getPassword();
        $this->loginButton = $this->loginView->isLoginButtonPushed(); 
        //MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        
        if($this->loginButton == true)
        {
            $message = $this->validateLogin();
            if($message == "")
            {
                $this->login();
            }
            else
            {            
                $this->loginView->setInfo($this->username, $message, false);
            }
        }
        else
        {
            $this->loginView->setInfo($this->username, "", false);
        }
        $isLoggedIn = $this->loginView->getIsLoggedIn();
        $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView); 
   }
   private function login()
   {
       $message = "Welcome";
       $this->loginView->setInfo($this->username, $message, true);
   }
}
