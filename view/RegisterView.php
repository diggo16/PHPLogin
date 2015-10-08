<?php
/**
 * View for the registration
 *
 * @author daniel
 */
class RegisterView 
{
    private $post;
    private $exceptionMsg;
    private $feedback;
    
    private static $register = "register";
    private static $message = "RegisterView::Message";
    private static $username = "RegisterView::UserName";
    private static $password = "RegisterView::Password";
    private static $repeatPassword = "RegisterView::PasswordRepeat";
    private static $registration = "RegisterView::Register";
    private static $textLength = 20;
    /**
     * Initializa objects
     */
    public function __construct() 
    {
        require_once ('PostObjects.php');
        require_once ('ExceptionMessages.php');
        require_once ('Feedback.php');
        $this->post = new PostObjects();
        $this->exceptionMsg = new ExceptionMessages();
        $this->feedback = new Feedback();
    }
    /**
     * Return a register form if the user don't already have put in valid
     * registration information
     * @return string htmlString
     */
    public function generateRegisterForm($message) 
    {
        $response = "";
        // If the registration button is pushed
        if(isset($_POST[self::$registration]))
        {
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
    public function getRegisterFormResponse($message, $username)
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
        if(isset($_GET[self::$register]))
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
     * Get the string for a successful registration
     * @return string successfulRegistration
     */
    public function getSuccessfulFeedback()
    {
        return $this->feedback->getSuccessfulRegistration();
    }
    /**
     * return the newly created user's username
     * @return string username
     */
    public function getUsername()
    {
        return $this->post->getStringWithoutFilter(self::$username);
    }
    /**
     * Get password
     * @return string password
     */
    public function getPassword()
    {
        return $this->post->getString(self::$password);  
    }
    /**
     * Get repeat password
     * @return string repeatPassword
     */
    public function getRepeatPassword()
    {
        return $this->post->getString(self::$repeatPassword);
    }
    /**
     * Check if submit button is clicked
     * @return boolean isSubmitButtonClicked
     */
    public function isSubmitButtonClicked()
    {
       if($this->post->isButtonPushed(self::$registration))
       {
           return true;
       }
       return false;
    }
}
