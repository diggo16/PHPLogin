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
   
   public function validateUsername($username)
   {
       $message = "correct";
       if($username == "")
        {
            $message = self::$usernameMissing;
        }
        return $message;
   }
}
