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
    /**
     * Get username too short string
     * @return string UsernameShort
     */
    public function getUsernameTooShort() 
    {
        return "UsernameShort";
    }
    /**
     * Get username illegal string
     * @return string usernameIllegal
     */
    public function getUsernameIllegal() 
    {
        return "UsernameIllegal";
    }
    /**
     * Get username exists string
     * @return string usernameExists
     */
    public function getUsernameExists() 
    {
        return "UsernameExists";
    }
    /**
     * Get password too short string
     * @return string passwordTooShort
     */
    public function getPasswordTooShort()    
    {
        return "PasswordShort";
    }
    /**
     * Get passwords dont match string
     * @return string passwordsDontMatch
     */
    public function getPasswordsDontMatch()
    {
        return "PasswordsDontMatch";
    }
    /**
     * Get invalid username string
     * @return string invalidUsername
     */
    public function getInvalidUsername()
    {
        return "UsernameInvalid";
    }
}
