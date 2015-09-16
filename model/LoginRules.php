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
   
   public function __construct($correctUser) 
   {
       require_once 'User.php';
       $this->correctUser = $correctUser;
   }
   public function isUsernameMissing($username) 
   {
       if($username == "")
       {
           return true;
       }
       return false;
   }
   public function isPasswordMissing($password) 
   {
       if($password == "")
       {
           return true;
       }
       return false;
   }
   public function isUsernameAndPasswordMatch($username, $password)
   {
       if($this->correctUser->getUsername() != $username || $this->correctUser->getPassword() != $password)
       {
           return false;
       }
       return true;
   }
}
