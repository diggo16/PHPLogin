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
   
   public function validateUsername($username)
   {
        $message = "correct";
        if($username == "")
        {
            $message = self::$usernameMissing;
        }
        return $message;
   }
   public function validatePassword($password)
   {
       $message = "correct";
       if($password == "")
       {
           $message = self::$passwordMissing;
       }
       return $message;
   }
   public function getCorrectMessage($usernameMsg, $user, $passwordMsg, $password)
   {
       $message = "";
       if($usernameMsg != "correct")
       {
            $message = $usernameMsg;
       }
       else if($passwordMsg != "correct")
       {
           $message = $passwordMsg;
       }
       
       else if($user != self::$username || $password != self::$password)
       {
           $message = self::$noMatch;
       }
       return $message;
   }
   public function ifCorrectLogin($username, $password) 
   {
      if(self::$username == $username && self::$password == $password)
      {
          return true;
      }
      return false;
   }
}
