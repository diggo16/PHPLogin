<?php
/**
 * Description of LoginRules
 *
 * @author Daniel
 */
class LoginRules {
   // correct information
   private static $username = "Admin";
   private static $password = "Password";
   
   // Error messages
   private static $usernameMissing = 'Username is missing';
   private static $passwordMissing = "Password is missing";
   private static $noMatch = "Wrong name or password";
   
   public function validateLogin($username, $password) 
    {
       if($username == "")
       {
           return self::$usernameMissing;
       }
       if($password == "")
       {
           return self::$passwordMissing;
       }
       if(self::$username != $username || self::$password != $password)
       {
           return self::$noMatch;
       }
       
   }
}
