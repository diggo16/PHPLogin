<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorMessages
 *
 * @author Daniel
 */
class ErrorMessages {
    private static $usernameMissing = "Username is missing";
    private static $passwordMissing = "Password is missing";
    private static $noMatch = "Wrong name or password";
    
    public static function getUsernameMissingMsg()
    {
        return self::$usernameMissing;
    }
    public static function getPasswordMissingMsg()
    {
        return self::$passwordMissing;
    }
    public static function getNoMatchMsg()
    {
        return self::$noMatch;
    }
    
}
