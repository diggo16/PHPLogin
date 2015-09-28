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
        require_once('model/UserFile.php');
        
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
        if($this->registerRules->isUsernameValid($username) == false && count($errors) == 0)
        {
            array_push($errors, $this->exceptionMsg->getInvalidUsername());
        }
        if(count($errors) == 0)
        {
            $this->saveUser($username, $password);
        }
        return $errors;
    }
    public function saveUser($username, $password)
    {
        $userFile = new UserFile();
        $userFile->addUser($username, $password, "", "");
    }
}
