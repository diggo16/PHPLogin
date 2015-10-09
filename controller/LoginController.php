<?php
/**
 * Description of LoginController
 *
 * @author Daniel
 */
class LoginController 
{
    private $loginRules;
    private $session;
    private $sessionName;
    private $sessionPassword;
    private $correctUsers;
    private $feedback;
    private $cookies;
    private $username;
    private $password;
    private static $user;
    private $userFile;
    private $sessionId;
    private $random;
    private $loginView;
    
    /**
    * Initialize other classes and save the sessionName and sessionPassword
    * @param string $sessionName
    * @param string $sessionPassword
    */
    public function __construct(LoginView $loginView) 
    {
        require_once 'model/LoginRules.php';
        require_once 'model/User.php';
        require_once 'view/Session.php';
        require_once 'view/Feedback.php';
        require_once 'view/Cookies.php';
        require_once 'model/UserFile.php';
        require_once('view/Server.php');
        require_once('model/RandomString.php');
        
        $this->loginView = $loginView;
        
        $this->random = new RandomString();
        $server = new Server();
        $this->userFile = new UserFile($server->getDocumentRootPath());
        
        $this->updateUser();
         
        self::$user = new User();
        $this->session = new Session();
        
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
    * Return true if the session exists else return false
    * @return boolean doesSessionExist
    */
   public function isSessionCorrect($userSession)
   {
       $this->updateUser();
       foreach ($this->correctUsers as $user) 
       {
           if($user->getSessionId() == $userSession)
           {
               return true;
           }
       }
       return false;
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
           $sessionId = $this->random->generateUniqueString($password);
           $this->userFile->addUser($username, $password, $sessionId, "");
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
   public function logout($cookiePassword)
   {
       $sessionId = $this->session->getSession($this->sessionId);
        // Remove session
        $this->session->removeSession($this->sessionId);
        $this->session->destroySession();
        $this->cookies->clearCookie($cookiePassword);
        
        $this->updateUser();
        $this->userFile->setUserFileWithSession($sessionId, "", "");
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
   public function authenticateWithSavedCredentials($username, $password, $cookiePassword)
   {
       $user = $this->authenticate($username, $password);
       if($user != null)
       {
           $cookiePass = $this->random->generateUniqueString($password);
           $this->cookies->setCookie($cookiePassword, $cookiePass);
           self::$user->setCookiePassword($cookiePass);
           $this->userFile->addUser($username, $password, self::$user->getSessionId(), $cookiePass);
       }
       return self::$user;     
   }
   /**
    * If the cookies if correct return true else false
    * @param string $cookiePassword
    * @return boolean ifCookies
    */
   public function authenticateCookies($cookiePassword)
   {
       $this->updateUser();
       foreach ($this->correctUsers as $user) 
       {
           if($this->cookies->getCookie($cookiePassword) == $user->getCookiePassword())
           {
               return true;
           }
       }
       return false;

   }
   /**
    * collect information from the user file
    */
    private function updateUser() 
    {
       $this->correctUsers = $this->userFile->getUsers();
       $this->loginRules = new LoginRules($this->correctUsers);
   }
}
