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
    private static $registration = "RegisterView::Register";    // LoginView::Login
    private static $textLength = 20;
    private static $controller;
    /**
     * Initializa objects
     */
    public function __construct() 
    {
        require_once ('PostObjects.php');
        require_once ('controller/RegisterController.php');
        require_once ('ExceptionMessages.php');
        require_once ('Feedback.php');
        $this->post = new PostObjects();
        self::$controller = new RegisterController();
        $this->exceptionMsg = new ExceptionMessages();
        $this->feedback = new Feedback();
    }
    /**
     * Return a register form if the user don't already have put in valid
     * registration information
     * @return string htmlString
     */
    public function generateRegisterForm() 
    {
        $response = "";
        // If the registration button is pushed
        if(isset($_POST[self::$registration]))
        {
            $message = $this->checkData();
            // If there is error in the input values
            if($message != "")
            {
                $response = $this->getRegisterFormResponse($message, $this->post->getString(self::$username));
            }
        }
        // Else return an empty registration form 
        else
        {
            $response = $this->getRegisterFormResponse("", "");
        }
        return $response;
    }
    /**
     * Return a registration form in html text
     * @param string $message
     * @param string $username
     * @return string htmlString
     */
    private function getRegisterFormResponse($message, $username)
    {
        return "<h2>Register new user</h2>
			<form action='?register' method='post' enctype='multipart/form-data'>
				<fieldset>
				<legend>Register a new user - Write username and password</legend>
					<p id='" . self::$message . "'>" . $message . "</p>
					<label for='" . self::$username ."' >Username :</label>
					<input type='text' size='" .self::$textLength . "' name='" . self::$username . "' id='RegisterView::UserName' value='" . $username . "' />
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
    /**
     * Call the controller and return error messages if there was any errors
     * @return string errorMessages
     */
    private function checkData()
    {
        // Call the controller to check for errors
        $errors = self::$controller->registerUser($this->post->getStringWithoutFilter(self::$username),
                                                   $this->post->getString(self::$password), 
                                                   $this->post->getString(self::$repeatPassword));
        return $this->getErrorMessages($errors);    // Translate the error codes to strings
    }
    /**
     * Generate a register text link in html
     * @return string htmlString
     */
    public function generateRegisterLink() 
    {
        return $this->generateLink(self::$register, "Register a new user");
    }
    /**
     * Generate a back to login text link in html
     * @return string htmlString
     */
    public function generateBackToLoginLink()
    {
        return $this->generateLink("", "Back to login");
    }
    /**
     * Generate a html link
     * @param string $link
     * @param string $text
     * @return string htmlLink
     */
    private function generateLink($link, $text)
    {
        $response = "<a href='?" . $link . "'>" . $text . "</a>";
        return $response;
    }
    /**
     * Check if the register text link is clicked
     * @return boolean isRegisterTextClicked
     */
    public function isRegisterTextClicked()
    {
        if(isset($_GET[self::$register]))   // TODO change to post->isButtonClicked()
        {
            return true;
        }
        return false;
    }
    /**
     * Check if there should be a text link in the response;
     * @param boolean $isLoggedIn
     * @return string htmlString
     */
    public function generateTextLink($isLoggedIn)
    {
        $response = "";
        // If the user is not logged in
        if(!$isLoggedIn)
        {
            $response = $this->generateRegisterLink();
        }
        // If the register text is clicked
        if($this->isRegisterTextClicked())
        {
            $response = $this->generateBackToLoginLink();
        }
        return $response;
    }
    /**
     * Check the array and translate the error codes to strings
     * @param array $errorArr
     * @return string errorMessages
     */
    private function getErrorMessages($errorArr)
    {
        // TODO refactor?
        $message = "";
        // If the username is too short
        if(in_array($this->exceptionMsg->getUsernameTooShort(), $errorArr))
        {
            $message .= $this->feedback->getUsernameTooShortMsg();
        }
        // If the password is too short
        if(in_array($this->exceptionMsg->getPasswordTooShort(), $errorArr))
        {
            $message = $this->ifAddBreak($message);
            $message .= $this->feedback->getPasswordTooShortMsg();
        }
        // If the username exists
        if(in_array($this->exceptionMsg->getUsernameExists(), $errorArr))    
        {
            $message = $this->ifAddBreak($message);
            $message .= $this->feedback->getUsernameAlreayExists();
        }
        // If the passwords don't match
        if(in_array($this->exceptionMsg->getPasswordsDontMatch(), $errorArr))
        {
            $message = $this->ifAddBreak($message);
            $message .= $this->feedback->getPasswordsDontMatch();
        }
        // If the username contains invalid characters
        if(in_array($this->exceptionMsg->getInvalidUsername(), $errorArr))
        {
            $message = $this->ifAddBreak($message);
            $message .= $this->feedback->getUsernameIsInvalidMsg();
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
    /**
     * Get the string for a successful registration
     * @return string successfulRegistration
     */
    public function getSucessfulFeedback()  // TODO misspell successful
    {
        return $this->feedback->getSucessfulRegistration();
    }
    /**
     * return the newly created user's username
     * @return string username
     */
    public function getUsername()
    {
        return $this->post->getString(self::$username);
    }
}
