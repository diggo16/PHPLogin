<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExceptionMessages
 *
 * @author daniel
 */
class ExceptionMessages 
{
    public function getUsernameTooShort() 
    {
        return "UsernameShort";
    }
    public function getUsernameIllegal() 
    {
        return "UsernameIllegal";
    }
    public function getUsernameExists() 
    {
        return "UsernameExists";
    }
    public function getPasswordTooShort()    
    {
        return "PasswordShort";
    }
}
