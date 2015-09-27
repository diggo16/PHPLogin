<?php
/**
 * Description of RegisterController
 *
 * @author daniel
 */
class RegisterController 
{
    private static $usernameArray;
    private $registerRules;
    private $exceptionMsg;
    public function __construct() 
    {
        require_once ("model/User.php");
        require_once ('view/ExceptionMessages.php');
        require_once ('model/RegisterRules.php');
        
        self::$usernameArray = array();
        $correctUser = new User();
        $correctUser->setNewInfo("Admin", "Password", false, "");
        self::$usernameArray[] = $correctUser;
        $this->exceptionMsg = new ExceptionMessages();
        $this->registerRules = new RegisterRules();
    }
    public function registerUser($username, $password, $repeatPassword) 
    {
        $errors = array();
        if($this->registerRules->checkUsernameFormat($username) == false)
        {
            array_push($errors, $this->exceptionMsg->getUsernameTooShort());
        }
        if($this->registerRules->checkPasswordFormat($password) == false)
        {
            array_push($errors, $this->exceptionMsg->getPasswordTooShort());
        }
        if($this->registerRules->checkUsernameAlreadyUsed($username) == true)
        {
            array_push($errors, $this->exceptionMsg->getUsernameExists());
        }
        if($this->registerRules->checkPasswordMatch($password, $repeatPassword) == false)
        {
            array_push($errors, $this->exceptionMsg->getPasswordsDontMatch());
        }
        return $errors;
    }
    private function checkUsername($username)
    {
        $message = array();
        if(strlen($username) < 3)
        {
            array_push($message, $this->exceptionMsg->getUsernameTooShort());
        }
        foreach (self::$usernameArray as $correctUser) 
        {
            if(strcmp($correctUser->getUsername(), $username) === 0)
            {
                array_push($message, $this->exceptionMsg->getUsernameExists());
                break;
            }
        }
        return $message;
    }
    private function checkPassword($password)
    {
        $message = array();
        if(strlen($password) < 6)
        {
            array_push($message, $this->exceptionMsg->getUsernameTooShort());
        }
        return $message;
    }
    private function checkRepeatPassword($password, $repeatPassword)
    {
        $message = "";
        $message = $repeatPassword;
        return $message;
    }
    private function addArr($array, $toBeAdded)
    {
        foreach ($toBeAdded as $value) 
        {
            $array[] = $value;
        }
        return $array;
    }
}
