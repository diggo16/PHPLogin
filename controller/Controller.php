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
    public function __construct() {
        require_once 'model/LoginRules.php';
        $this->loginRules = new LoginRules();
    }
   public function validateLogin($username, $password)
   {
       $message = $this->loginRules->validateUsername($username);
       return $message;
   }
}
