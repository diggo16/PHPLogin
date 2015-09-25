<?php
/**
 * Description of RegisterController
 *
 * @author daniel
 */
class RegisterController 
{
    public function __construct() 
    {
        
    }
    public function registerUser($username, $password, $repeatPassword) 
    {
        $message = $this->checkUsername($username);
        $message .=$this->checkPassword($password);
        $message .= $this->checkRepeatPassword($password, $repeatPassword);
        return $message;
    }
    private function checkUsername($username)
    {
        $message = "";
        $message = $username;
        return $message;
    }
    private function checkPassword($password)
    {
        $message = "";
        $message = $password;
        return $message;
    }
    private function checkRepeatPassword($password, $repeatPassword)
    {
        $message = "";
        $message = $repeatPassword;
        return $message;
    }
}
