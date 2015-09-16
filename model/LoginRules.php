<?php
/**
 * Description of LoginRules
 *
 * @author Daniel
 */
class LoginRules 
{
   // correct user
   private $correctUser;
   
   // Error messages
   private static $usernameMissing = 'Username is missing';
   private static $passwordMissing = "Password is missing";
   private static $noMatch = "Wrong name or password";
   
   public function __construct($correctUser) 
   {
       require_once 'User.php';
       $this->correctUser = $correctUser;
   }
   
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
       if($this->correctUser->getUsername() != $username || $this->correctUser->getPassword() != $password)
       {
           return self::$noMatch;
       }
       
   }
}
