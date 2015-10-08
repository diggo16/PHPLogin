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
        private static $sessionId = "Session::Id";
        private static $sessionMessage = "Session:Message";
        
        private static $user;
        private $session;
        private $feedback;
        private $post;
        private $cookies;

        /**
         * Initialize the objects
         */
        public function __construct() 
        {
            require_once('Session.php');
            require_once('Feedback.php');
            require_once('PostObjects.php');
            require_once('Cookies.php');
            
            self::$user = new User();
              
            $this->session = new Session();
            $this->feedback = new Feedback();
            $this->post = new PostObjects();
            $this->cookies = new Cookies();
        }
        /**
         * Return a login form with the parameters as message and username
         * @param string $message
         * @param string $username
         * @return string htmlString
         */
        public function responseWithParameters($message, $username)
        {
           return $this->generateLoginFormHTML($message, $username);
        }

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) 
        {
            $this->session->setSession(self::$sessionMessage, $message);
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
        public function generateHTML($loggedIn, $message, $username)
        {
            if($loggedIn == true)
            {
                return $this->generateLogoutButtonHTML($message);
            }
            return $this->generateLoginFormHTML($message, $username);
        }
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $username) 
        {
            $this->session->setSession(self::$sessionMessage, $message);
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
         * Check if there is cookies
         * @return boolean isCookies
         */
        public function isCookies()
        {
            // If the cookies is not empty
            if($this->cookies->getCookie(self::$cookieName) !="" && $this->cookies->getCookie(self::$cookiePassword))
            {
                return true;
            }
            return false;
        }
        public function isSession()
        {
            if($this->session->getSession(self::$sessionId))
            {
                return true;
            }
            return false;
        }
        public function isLoggedInButtonPushed()
        {
            if($this->post->isButtonPushed(self::$login))
            {
                return true;
            }
            return false;
        }
        public function isLoggedOutButtonPushed() 
        {
            if($this->post->isButtonPushed(self::$logout))
            {
                return true;
            }
            return false;
        }
        public function getUsername()
        {
            return $this->post->getString(self::$name);
        }
        public function getPassword()
        {
             return $this->post->getString(self::$password);
        }
        public function responseWithUser(User $user)
        {
            if($user->isLoggedIn())
            {
                return $this->generateLogoutButtonHTML($user->getMessage());
            }
            else 
            {
               return $this->generateLoginFormHTML($user->getMessage(), $user->getUsername()); 
            }
        }
        public function getSessionId()
        {
            return $this->session->getSession(self::$sessionId);
        }
        public function setSessionId($id)
        {
            $this->session->setSession(self::$sessionId, $id);
        }
        public function getCookieName()
        {
            return self::$cookiePassword;
        }
        public function isKeepChecked()
        {
            if($this->post->isButtonPushed(self::$keep))
            {
                return true;
            }
            return false;
        }
}