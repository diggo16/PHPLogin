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
    public function __construct() {
        require_once 'model/LoginRules.php';
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        
        $this->loginRules = new LoginRules();
    }
   public function validateLogin($username, $password)
   {
       $message = $this->loginRules->validateUsername($username);
       return $message;
   }
   public function start()
   {
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->layoutView = new LayoutView();
      //MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        
        $username = $this->loginView->getUsername();
        //$password = 

        $this->layoutView->render(false, $this->loginView, $this->dateTimeView); 
   }
}
