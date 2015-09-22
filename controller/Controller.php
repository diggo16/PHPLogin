<?php
/**
 * Description of Controller
 *
 * @author Daniel
 */
class Controller 
{
    private $loginRules;
    private $loginView;
    private $session;
    private $sessionName;
    private $sessionPassword;
    private $correctUser;
    private $feedback;
    private $cookies;
    private $username;
    private $password;
    private static $user;
    private $userFile;
    private $sessionId;
    
    /**
    * Initialize other classes and save the sessionName and sessionPassword
    * @param string $sessionName
    * @param string $sessionPassword
    */
    public function __construct($sessionName, $sessionPassword, $sessionId) 
    {
        require_once 'model/LoginRules.php';
        require_once 'model/User.php';
        require_once 'view/Session.php';
        require_once 'view/Feedback.php';
        require_once 'view/Cookies.php';
        require_once 'model/UserFile.php';
        
        $this->sessionId = $sessionId;
        
        $this->updateUser();
         
        self::$user = new User();
        $this->session = new Session();
        
        $id = $this->session->generateUniqueID();
        $this->correctUser->setSessionId($id);
        $this->sessionName = $sessionName;
        $this->sessionPassword = $sessionPassword;
        $this->feedback = new Feedback();
        $this->cookies = new Cookies();
        
    }
   /**
    * Check if the username and password is correct. Return error message if
    * it's not correct.
    * @return string $message
    */ 
   private function validateLogin()
   {
       $this->updateUser();
       $message = "";
       if($this->loginRules->isUsernameMissing($this->username))
       {
           $message =  $this->feedback->getUsernameMissingMsg();
       }
       else if($this->loginRules->isPasswordMissing($this->password))
       {
           $message = $this->feedback->getPasswordMissingMsg();
       }
       else if(!$this->loginRules->isUsernameAndPasswordMatch($this->username, $this->password))
       {
           $message = $this->feedback->getNoMatchMsg();
       }
       return $message;
   }
   /**
    * return the session id for the correct user
    * @return string sessionId
    */
   public function getCorrectSessionId()
   {
       $this->updateUser();
       return $this->correctUser->getSessionId();
   }
   /**
    * Create the new user and return it. Log in the user if the info is correct.
    * @param string $username
    * @param string $password
    * @return User $user
    */
   public function authenticate($username, $password)
   {
       $this->username = $username;
       $this->password = $password;
       $message = $this->validateLogin();
       $this->loginView = new LoginView(); 
       $loggedIn = false;
       $sessionId = "";
       if($message == "")
       {
           $loggedIn = true;
           $sessionId = $this->session->generateUniqueID();
           $this->userFile->setUserFile($sessionId, "");
           $this->session->setSession($this->sessionId, $sessionId);
           self::$user->setSessionId($sessionId);
           // Add session info                       
           $this->session->setSession($this->sessionName, self::$user->getUsername());
           $this->session->setSession($this->sessionPassword, self::$user->getPassword());
           
       }
       self::$user->setNewInfo($this->username, $this->password, $loggedIn, $message);
       return self::$user;
   }
  /**
   * Log out the user and remove session and cookies
   * @param type $sessionUsername
   * @param type $sessionPassword
   * @param type $cookieName
   * @param type $cookiePassword
   */
   public function logout($sessionUsername, $sessionPassword, $cookieName, $cookiePassword)
   {
        // Remove session
        $this->session->removeSession($sessionUsername);
        $this->session->removeSession($sessionPassword);
        $this->session->removeSession($this->sessionId);
        $this->session->destroySession();
        $this->cookies->clearCookie($cookieName);
        $this->cookies->clearCookie($cookiePassword);
        
        $this->updateUser();
        $this->userFile->setUserFile("", "");
   }
   /**
    * Authenticate the user and save the information in cookies if
    * it is correct.
    * @param string $username
    * @param string $password
    * @param string $cookieName
    * @param string $cookiePassword
    * @return User $user
    */
   public function authenticateWithSavedCredentials($username, $password, $cookieName, $cookiePassword)
   {
       $this->authenticate($username, $password);
       if(self::$user->isLoggedIn())
       {
            $cookiePass = $this->cookies->generateCookiePassword();
            $this->cookies->setCookie($cookieName, self::$user->getUsername());
            $this->cookies->setCookie($cookiePassword, $cookiePass);
            self::$user->setCookiePassword($cookiePass);
            $this->userFile->setUserFile(self::$user->getSessionId(), $cookiePass);
       }
       return self::$user;     
   }
   /**
    * If the cookies if correct return true else false
    * @param string $cookieName
    * @param string $cookiePassword
    * @return boolean ifCookies
    */
   public function authenticateCookies($cookieName, $cookiePassword)
   {
        if($this->cookies->getCookie($cookieName) === $this->correctUser->getUsername() && 
        $this->cookies->getCookie($cookiePassword) === $this->correctUser->getCookiePassword())
        {
            return true;
        }
        return false;
   }
   /**
    * collect information from the user file
    */
    private function updateUser() 
    {
       $this->userFile = new UserFile();
       $this->correctUser = $this->userFile->getUser();
       $this->loginRules = new LoginRules($this->correctUser);
   }
}
