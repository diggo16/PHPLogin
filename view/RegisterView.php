<?php
/**
 * Description of RegisterView
 *
 * @author daniel
 */
class RegisterView 
{
    private $post;
    private $exceptionMsg;
    private $feedback;
    
    private static $register = "register";
    private static  $message = "RegisterView::Message";
    private static  $username = "RegisterView::UserName";
    private static  $password = "RegisterView::Password";
    private static  $repeatPassword = "RegisterView::PasswordRepeat";
    private static $registration = "DoRegistration";
    private static $textLength = 20;
    private static $controller;
    public function __construct() 
    {
        require_once ('PostObjects.php');
        require_once ('controller/RegisterController.php');
        require_once ('ExceptionMessages.php');
        $this->post = new PostObjects();
        self::$controller = new RegisterController();
        $this->exceptionMsg = new ExceptionMessages();
    }
    public function generateRegisterForm() 
    {
        $response = "";
        if(isset($_POST[self::$registration]))
        {
            $message = $this->checkData();
            if($message != "")
            {
                $response = $this->getRegisterFormResponse($message);
            }
        }
        else
        {
            $response = $this->getRegisterFormResponse("");
        }
        return $response;
    }
    private function getRegisterFormResponse($message)
    {
        return "<h2>Register new user</h2>
			<form action='?register' method='post' enctype='multipart/form-data'>
				<fieldset>
				<legend>Register a new user - Write username and password</legend>
					<p id='" . self::$message . "'>" . $message . "</p>
					<label for='" . self::$username ."' >Username :</label>
					<input type='text' size='" .self::$textLength . "' name='" . self::$username . "' id='RegisterView::UserName' value='' />
					<br/>
					<label for='" .self::$password . "' >Password  :</label>
					<input type='password' size='" .self::$textLength . "' name='" .self::$password . "' id='RegisterView::Password' value='' />
					<br/>
					<label for='" .self::$repeatPassword . "' >Repeat password  :</label>
					<input type='password' size='" .self::$textLength . "' name='" .self::$repeatPassword . "' id='RegisterView::PasswordRepeat' value='' />
					<br/>
					<input id='submit' type='submit' name='" .self::$registration . "'  value='Register' />
					<br/>
				</fieldset>";
    }
    private function checkData()
    {
        $errors = self::$controller->registerUser($this->post->getString(self::$username),
                                                   $this->post->getString(self::$password), 
                                                   $this->post->getString(self::$repeatPassword));
        return $this->getErrorMessages($errors);
    }
    public function generateRegisterLink() 
    {
        $response = "<a href='?" . self::$register . "'>Register a new user</a>";
        return $response;
    }
    public function generateBackToLoginLink()
    {
        $response = "<a href='?'>Back to login</a>";
        return $response;
    }
    public function isRegisterTextClicked()
    {
        if(isset($_GET[self::$register]))
        {
            return true;
        }
        return false;
    }
    public function generateTextLink($isLoggedIn)
    {
        $response = "";
        if(!$isLoggedIn)
        {
            $response = $this->generateRegisterLink();
        }
        if($this->isRegisterTextClicked())
        {
            $response = $this->generateBackToLoginLink();
        }
        return $response;
    }
    // TODO add messages to feedback
    private function getErrorMessages($errorArr)
    {
        $message = "";
        if(in_array($this->exceptionMsg->getUsernameTooShort(), $errorArr))
        {
            $message .= "Username too short";
        }
        if(in_array($this->exceptionMsg->getPasswordTooShort(), $errorArr))
        {
            $message = $this->ifAddBreak($message);
            $message .= "Password is too short";
        }
        if(in_array($this->exceptionMsg->getUsernameExists(), $errorArr))    
        {
            $message = $this->ifAddBreak($message);
            $message .= "Username already exists";
        }
        return $message;
    }
    private function ifAddBreak($message)
    {
        if($message != "")
        {
            $message .= "<br />";
        }
        return $message;
    }
}
