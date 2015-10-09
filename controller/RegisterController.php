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
    private $userFile;
    private $feedback;
    private $session;
    private static $newRegistration = "RegisterController::newRegistration";
    /**
     * Initialize objects
     */
    public function __construct() 
    {
        require_once("model/User.php");
        require_once('view/ExceptionMessages.php');
        require_once('model/RegisterRules.php');
        require_once('model/UserFile.php');
        require_once('view/Server.php');
        require_once('view/Feedback.php');
        require_once('view/RegisterView.php');
        require_once('view/Session.php');
        
        $this->feedback = new Feedback();
        $this->session = new Session();
       
        $server = new Server();
        $this->userFile = new UserFile($server->getDocumentRootPath());
        self::$usernameArray = array();
        $users = $this->userFile->getUsers();
        foreach ($users as $user)
        {
            self::$usernameArray[] = $user->getUsername();
        }
        $this->exceptionMsg = new ExceptionMessages();
        $this->registerRules = new RegisterRules(self::$usernameArray);
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
            $this->session->setSession(self::$newRegistration, "yes");
            $this->saveUser($username, $password);
            $this->userFile->addToTemp($username);
            header("location:?");
        }
        return $errors;
    }
    /**
     * Save the user to the UserFile
     * @param var $username
     * @param var $password
     */
    private function saveUser($username, $password)
    {
        $this->userFile->addUser($username, $password, "", "");
    }
    public function getTempUsername()
    {
        $username = $this->userFile->getTempUsername();
        $this->userFile->clearTemp();
        return $username;
    }
    public function isNewUser()
    {
        if($this->session->getSession(self::$newRegistration) != "")
        {
            unset($_SESSION[self::$newRegistration]);
            $this->session->removeSession(self::$newRegistration);
            return true;
        }
        return false;
    }
    /**
     * Check the array and translate the error codes to strings
     * @param array $errorArr
     * @return string errorMessages
     */
    public function getErrorMessages($errorArr)
    {
        $message = "";
        // Array with every exception errors
        $exceptionArr = array($this->exceptionMsg->getUsernameTooShort(),
                              $this->exceptionMsg->getPasswordTooShort(),
                              $this->exceptionMsg->getUsernameExists(),
                              $this->exceptionMsg->getPasswordsDontMatch(),
                              $this->exceptionMsg->getInvalidUsername());
        // Array with every feedback messages
        $feedbackArr = array($this->feedback->getUsernameTooShortMsg(),
                             $this->feedback->getPasswordTooShortMsg(),
                             $this->feedback->getUsernameAlreayExists(),
                             $this->feedback->getPasswordsDontMatch(),
                             $this->feedback->getUsernameIsInvalidMsg());
        // Check if the error is in the errorArray and add a message if there is
        for($i = 0; $i < count($exceptionArr); $i++)
        {
            if(in_array($exceptionArr[$i], $errorArr))
            {
                $message = $this->ifAddBreak($message);
                $message .= $feedbackArr[$i];       // add message
            } 
        }
        return $message;
    }
        /**
     * Add a break to the string if the messsage isn't empty
     * @param string $message
     * @return string $message
     */
    private function ifAddBreak($message)
    {
        if($message != "")
        {
            $message .= "<br />";
        }
        return $message;
    }
}