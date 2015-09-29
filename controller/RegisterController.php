<?php
/**
 * A controller that handles the registration
 *
 * @author daniel
 */
class RegisterController 
{
    private static $usernameArray;
    private $registerRules;
    private $exceptionMsg;
    /**
     * Initialize objects
     */
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
    /**
     * Check if the information is valid, else return error messages
     * @param var $username
     * @param var $password
     * @param var $repeatPassword
     * @return array $errors
     */
    public function registerUser($username, $password, $repeatPassword) 
    {
        $errors = array();
        // If the username is too short
        if($this->registerRules->checkUsernameFormat($username) == false)
        {
            array_push($errors, $this->exceptionMsg->getUsernameTooShort());
        }
        // If the password is too short
        if($this->registerRules->checkPasswordFormat($password) == false)
        {
            array_push($errors, $this->exceptionMsg->getPasswordTooShort());
        }
        // If the username is already used
        if($this->registerRules->checkUsernameAlreadyUsed($username) == true)
        {
            array_push($errors, $this->exceptionMsg->getUsernameExists());
        }
        // If the password dont match the repeat password
        if($this->registerRules->checkPasswordMatch($password, $repeatPassword) == false)
        {
            array_push($errors, $this->exceptionMsg->getPasswordsDontMatch());
        }
        // If the username has illegal characters
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
    /**
     * Save the user to the UserFile
     * @param var $username
     * @param var $password
     */
    public function saveUser($username, $password)
    {
        $userFile = new UserFile();
        $userFile->addUser($username, $password, "", "");
    }
}
