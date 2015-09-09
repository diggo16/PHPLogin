<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
        
        private static  $errorMsg;
        private static $username;
        private static $message;
        private static $isLoggedIn;

        public function __construct() {
            require_once 'ErrorMessages.php';
            self::$errorMsg = new ErrorMessages();
        }

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
            
            $response = "";
            if(self::$isLoggedIn == TRUE)
            {
                
            }
            else
            {
                $response = $this->generateLoginFormHTML(self::$message,self::$username);
            }
            return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $username) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $username . '"/>

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
        public function getUsername()
        {
            $username = filter_input(INPUT_POST,self::$name,FILTER_SANITIZE_STRING);;
                return $username;
        }
        public function getPassword()
        {
                    $password = filter_input(INPUT_POST,self::$password,FILTER_SANITIZE_STRING);
                return $password;
        }
        public function isLoginButtonPushed() 
        {
            if(isset($_POST[self::$login]))
            {
                return true;
            }
            return false;
        }
        public function setInfo($username, $message, $isLoggedIn)
        {
            self::$username = $username;
            self::$message = $message;
            self::$isLoggedIn = $isLoggedIn;
        }
        private function getString($string)
        {
            if(isset($_POST[$string]))
            {
                if($_POST[$string] == "")
                {
                    return "";
                }
                else
                {
                    return $_POST[$string];
                }
            }
            return "";
        }
        
	
}