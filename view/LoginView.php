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
        private $cookies;

        public function __construct() 
        {
            require_once 'controller/Controller.php';
            require_once 'Session.php';
            require_once 'Feedback.php';
            require_once 'PostObjects.php';
            require_once 'Cookies.php';
            
            self::$controller = new Controller(self::$sessionName, self::$sessionPassword);
            self::$user = new User();
              
            $this->session = new Session();
            $this->feedback = new Feedback();
            $this->post = new PostObjects();
            $this->cookies = new Cookies();
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
                // If it exists session info
                if($this->session->isSessionExist(self::$sessionName, self::$sessionPassword))
                {
                    $response = $this->generateLoginFormHTML($this->feedback->getByeMsg(),"");
                }
                else 
                {
                   $response = $this->generateLoginFormHTML("",""); 
                }
                self::$controller->logout(self::$sessionName, self::$sessionPassword, self::$cookieName, self::$cookiePassword);      
            }
            // Else if the session is valid
            else if($this->session->isSessionLoggedIn(self::$sessionName, self::$sessionPassword, $correctId))
            {
                $response = $this->generateLogoutButtonHTML("");
            }
            // Else if there is valid cookies
            else if($this->isCookies())
            {
                // If the cookies is valid, login the person
                if(self::$controller->authenticateCookies($this->cookies->getCookie(self::$cookieName), $this->cookies->getCookie(self::$cookiePassword)))
                {
                    self::$user->login();
                    $response = $this->generateLogoutButtonHTML($this->feedback->getWelcomeCookieMsg());
                }
                // Else return to login form with wrong cookies error text
                else
                {
                    $response = $this->generateLoginFormHTML($this->feedback->getWrongInformationCookies(),"");
                }
                
            }
            else
            {
                // If the login button is pushed
                if($this->post->isButtonPushed(self::$login))
                {
                    $response = $this->login();       
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
        /**
         * Get if the user is logged in or not
         * @return Boolean isLoggedIn
         */
        public function isLoggedIn() 
        {
            $correctId = self::$controller->getCorrectSessionId();  // Get the correct session ID
            if($this->session->isSessionLoggedIn(self::$sessionName, self::$sessionPassword, $correctId))
            {
                return true;
            }
            return self::$user->isLoggedIn();
        }
        /**
         * If the login button was pushed, check if the info was correct.
         * Return HTML text for a logged in person if the info is correct 
         * else return loginform with error message
         * @return type HTMLText
         */
        private function login()
        {
            $response = "";
            // If the keep checkbox is checked
            if($this->post->isButtonPushed(self::$keep))
            {
                 self::$user = self::$controller->authenticateWithSavedCredentials($this->post->getString(self::$name), 
                                                                                   $this->post->getString(self::$password), 
                                                                                   self::$cookieName, self::$cookiePassword);     
            }
            // Else login if the info is correct without saving cookies
            else 
            {
                self::$user = self::$controller->authenticate($this->post->getString(self::$name), $this->post->getString(self::$password));
            }
            // If the user is logged in, return logged in screen with welcome message
            if(self::$user->isLoggedIn())
            {
                $response = $this->generateLogoutButtonHTML($this->feedback->getWelcomeMsg());
            }
            // Else return login form
            else
            {
                $response = $this->generateLoginFormHTML(self::$user->getMessage(),self::$user->getUsername());
            }
            return $response;
        }
        /**
         * Check if there is cookies
         * @return boolean isCookies
         */
        private function isCookies()
        {
            // If the cookies is not empty
            if($this->cookies->getCookie(self::$cookieName) !="" && $this->cookies->getCookie(self::$cookiePassword))
            {
                return true;
            }
            return false;
        }
}