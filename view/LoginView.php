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
        private static $sessionName = 'Session::SessionName';
        private static $sessionPassword = 'Session::SessionPassword';
        
        private static $controller;
        private static $user;
        private $session;
        private $feedback;
        private $post;

        public function __construct() 
        {
            require_once 'controller/Controller.php';
            require_once 'Session.php';
            require_once 'Feedback.php';
            require_once 'PostObjects.php';
            self::$controller = new Controller(self::$sessionName, self::$sessionPassword);
            self::$user = new User();
              
            $this->session = new Session();
            $this->feedback = new Feedback();
            $this->post = new PostObjects();
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
            $correctId = self::$controller->getCorrectSessionId();
            // If the logout button is pushed
            if($this->post->isButtonPushed(self::$logout))
            {
                if($this->session->isSessionExist(self::$sessionName, self::$sessionPassword))
                {
                    $response = $this->generateLoginFormHTML($this->feedback->getByeMsg(),"");
                }
                else 
                {
                   $response = $this->generateLoginFormHTML("",""); 
                }
                self::$controller->logout(self::$sessionName, self::$sessionPassword);      
            }
            // Else if the session is valid
            else if($this->session->isSessionLoggedIn(self::$sessionName, self::$sessionPassword, $correctId))
            {
                $response = $this->generateLogoutButtonHTML("");
            }
            else
            {
                // If the login button is pushed
                if($this->post->isButtonPushed(self::$login))
                {
                    self::$user = self::$controller->authenticate($this->post->getString(self::$name), $this->post->getString(self::$password));
                    if(self::$user->isLoggedIn())
                    {
                        $response = $this->generateLogoutButtonHTML($this->feedback->getWelcomeMsg());
                    }
                    else
                    {
                        $response = $this->generateLoginFormHTML(self::$user->getMessage(),self::$user->getUsername());
                    }        
                }
                else
                {
                    $response = $this->generateLoginFormHTML("","");
                }
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
			<form method="post"> 
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
        /**
         * Get if the user is logged in or not
         * @return Boolean isLoggedIn
         */
        public function isLoggedIn() 
        {
            $correctId = self::$controller->getCorrectSessionId();
            if($this->session->isSessionLoggedIn(self::$sessionName, self::$sessionPassword, $correctId))
            {
                return true;
            }
            return self::$user->isLoggedIn();
        }
}