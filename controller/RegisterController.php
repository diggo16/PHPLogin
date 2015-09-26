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
        $userErrors = $this->checkUsername($username);
        //$passwordErrors[] =$this->checkPassword($password);
        //$repPassErrrors[] = $this->checkRepeatPassword($password, $repeatPassword);
        $errors = [];
        $errors = $this->addArr($errors, $userErrors);
        var_dump($errors);
        return $errors;
    }
    private function checkUsername($username)
    {
        $message = [];
        if(strlen($username) < 3)
        {
            array_push($message, $this->exceptionMsg->getUsernameTooShort());
        }
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
        {
            array_push($message, $this->exceptionMsg->getUsernameIllegal());
            //throw new Exception($this->exceptionMsg->getUsernameIllegal());
        }
        foreach (self::$usernameArray as $correctUser) 
        {
            if(strcmp($correctUser->getUsername(), $username) === 0)
            {
                array_push($message, $this->exceptionMsg->getUsernameExists());
                break;
                //throw new Exception($this->exceptionMsg->getUsernameExists());
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
    private function addArr($array, $toBeAdded)
    {
        foreach ($toBeAdded as $value) 
        {
            $array[] = $value;
        }
        return $array;
    }
}
