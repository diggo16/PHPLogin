<?php
class LoginView 
{
    /*
     * String names on POST and SESSION objects
     */
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private static $sessionId = "Session::Id";
    private static $sessionMessage = "Session:Message";

    /*
     * Objects
     */
    private $session;
    private $post;
    private $cookies;

    /**
     * Initialize the objects
     */
    public function __construct() 
    {    
        require_once('Session.php');
        require_once('PostObjects.php');
        require_once('Cookies.php');

        $this->session = new Session();
        $this->post = new PostObjects();
        $this->cookies = new Cookies();
    }
    /**
     * Return the correct html code depending on if the user is logged in
     * or not and what message it has
     * @param User $user
     * @return string htmlString
     */
    public function responseWithUser(User $user)
    {
        // If the user is logged in
        if($user->isLoggedIn())
        {
            return $this->generateLogoutButtonHTML($user->getMessage());    // Return logout button
        }
        else 
        {
           return $this->generateLoginFormHTML($user->getMessage(), $user->getUsername());  // Return login form
        }
    }
    /**
     * Check if there is cookies
     * @return boolean isCookies
     */
    public function isCookies()
    {
        // If the cookies is not empty
        if($this->cookies->getCookie(self::$cookiePassword))
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the login button is pushed
     * @return boolean isLoginButtonPushed
     */
    public function isLoggedInButtonPushed()
    {
        if($this->post->isButtonPushed(self::$login))
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the logout button is pushed
     * @return boolean isLogoutButtonPushed
     */
    public function isLoggedOutButtonPushed() 
    {
        if($this->post->isButtonPushed(self::$logout))
        {
            return true;
        }
        return false;
    }
    /**
     * Return the username
     * @return string username
     */
    public function getUsername()
    {
        return $this->post->getString(self::$name);
    }
    /**
     * Return the password
     * @return string password
     */
    public function getPassword()
    {
         return $this->post->getString(self::$password);
    }
    /**
     * Return the session id name
     * @return string $sessionId
     */
    public function getSessionIdName()
    {
        return self::$sessionId;
    }
    /**
     * Return the cookie password name
     * @return string $cookiePassword
     */
    public function getCookieName()
    {
        return self::$cookiePassword;
    }
    /**
     * Return true if the checkbox is checked else return false
     * @return boolean isKeepChecked
     */
    public function isKeepChecked()
    {
        if($this->post->isButtonPushed(self::$keep))
        {
            return true;
        }
        return false;
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
}