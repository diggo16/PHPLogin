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
    * @param string $username
    * @return boolean
    */
   public function isUsernameMissing($username) 
   {
       if($username == "")
       {
           return true;
       }
       return false;
   }
    /**
    * Check if the password is missing
    * @param string $password
    * @return boolean
    */
   public function isPasswordMissing($password) 
   {
       if($password == "")
       {
           return true;
       }
       return false;
   }
    /**
    * Check if the username and password match with the correct user
    * @param string $username
    * @param string $password
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
}
