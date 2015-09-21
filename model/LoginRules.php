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
   /**
    * Add the correct user
    * @param User $correctUser
    */
   public function __construct($correctUser) 
   {
       require_once 'User.php';
       $this->correctUser = $correctUser;
   }
   /**
    * Check if the username is missing
    * @param String $username
    * @return boolean
    */
   public function isUsernameMissing($username) 
   {
       return $this->isEmpty($username);
   }
   /**
    * Check if the password is missing
    * @param String $password
    * @return boolean
    */
   public function isPasswordMissing($password) 
   {
       return $this->isEmpty($password);
   }
   /**
    * Check if the username and password match with the correct user
    * @param String $username
    * @param String $password
    * @return boolean
    */
   public function isUsernameAndPasswordMatch($username, $password)
   {
       if($this->correctUser->getUsername() != $username || $this->correctUser->getPassword() != $password)
       {
           return false;
       }
       return true;
   }
   /**
    * Check if the string is empty
    * @param type $string
    * @return boolean
    */
   private function isEmpty($string)
   {
       if($string == "")
       {
           return true;
       }
       return false;
   }
}
