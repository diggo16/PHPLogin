<?php
/**
 * Description of RegisterController
 *
 * @author daniel
 */
class RegisterController 
{
    private static $usernameArray;
    private $exceptionMsg;
    public function __construct() 
    {
        require_once ("model/User.php");
        require_once ('view/ExceptionMessages.php');
        self::$usernameArray = [];
        $correctUser = new User();
        $correctUser->setNewInfo("Admin", "Password", false, "");
        self::$usernameArray[] = $correctUser;
        $this->exceptionMsg = new ExceptionMessages();
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
        if(strlen($username) < 3)
        {
            throw new Exception($this->exceptionMsg->getUsernameTooShort());
        }
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
        {
            throw new Exception($this->exceptionMsg->getUsernameIllegal());
        }
        foreach (self::$usernameArray as $correctUser) 
        {
            if(strcmp($correctUser->getUsername(), $username) === 0)
            {
                throw new Exception($this->exceptionMsg->getUsernameExists());
            }
        }
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
