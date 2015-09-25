<?php
/**
 * Description of RegisterView
 *
 * @author daniel
 */
class RegisterView 
{
    private $post;
    private static $register = "register";
    private static  $message = "RegisterView::Message";
    public function __construct() 
    {
        require_once ('PostObjects.php');
        $post = new PostObjects();
    }
    public function generateRegisterForm() 
    {
        return "<h2>Register new user</h2>
			<form action='?register' method='post' enctype='multipart/form-data'>
				<fieldset>
				<legend>Register a new user - Write username and password</legend>
					<p id='RegisterView::Message'></p>
					<label for='RegisterView::UserName' >Username :</label>
					<input type='text' size='20' name='RegisterView::UserName' id='RegisterView::UserName' value='' />
					<br/>
					<label for='RegisterView::Password' >Password  :</label>
					<input type='password' size='20' name='RegisterView::Password' id='RegisterView::Password' value='' />
					<br/>
					<label for='RegisterView::PasswordRepeat' >Repeat password  :</label>
					<input type='password' size='20' name='RegisterView::PasswordRepeat' id='RegisterView::PasswordRepeat' value='' />
					<br/>
					<input id='submit' type='submit' name='DoRegistration'  value='Register' />
					<br/>
				</fieldset>";
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
}
