<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feedback
 *
 * @author Daniel
 */
class Feedback 
{
    public function getWelcomeMsg()
    {
        return "Welcome";
    }
    public function getByeMsg() 
    {
       return "Bye bye!";
    }
    public function getUsernameMissingMsg()
    {
        return "Username is missing";
    }
    public function getPasswordMissingMsg()
    {
        return "Password is missing";
    }
    public function getNoMatchMsg() 
    {
        return "Wrong name or password";
    }
}
