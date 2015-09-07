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
    private $dateTimeView;
    private $layoutView;
    
    private $username;
    private $password;
    private $loginButton;
    private $logoutButton;
    private $cookies;
    
    private static $usernameCookie = "username";
    private static $passwordCookie = "password";
    public function __construct() 
    {
        require_once 'model/LoginRules.php';
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        require_once('view/Cookies.php');
        
        $this->loginRules = new LoginRules();
        $this->cookies = new Cookies();
    }
   public function validateLogin()
   {
       $usernameMessage = $this->loginRules->validateUsername($this->username);
       $passwordMessage = $this->loginRules->validatePassword($this->password);
       $message = $this->loginRules->getCorrectMessage($usernameMessage,  $this->username, $passwordMessage, $this->password);
       return $message;
   }
   public function start()
   {
       $this->initializeObjects();
       $message = "";
        
        //MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        
         // If the logout button is pushed
        if($this->logoutButton == true)
        {
                $this->logout();
        }
        else if($this->ifCookies())
        {
            $this->login("");
        }
        else
        {
            // If the login button is pushed
            if($this->loginButton == true)
            {
                $message = $this->validateLogin();
                if($message == "")
                {
                    $this->login("Welcome");
                }
                else
                {            
                    $this->loginView->setInfo($this->username, $message, false);
                }
            }
            // If no button is pushed
            if($this->logoutButton == false && $this->loginButton == false)
            {
                $this->loginView->setInfo($this->username, "", false);
            } 
        }
        echo $this->cookies->getCookie(self::$usernameCookie);
        echo $this->cookies->getCookie(self::$passwordCookie);
        $isLoggedIn = $this->loginView->getIsLoggedIn();
        $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView); 
   }
   /*
    * Login
    */
   private function login($message)
   {
       $this->loginView->setInfo($this->username, $message, true);
       
       if($this->loginView->keepBoxChecked() == true)
       {
           $this->cookies->setCookie(self::$usernameCookie, $this->username);
           $this->cookies->setCookie(self::$passwordCookie, $this->password);
       }
   }
   /*
    * Logout
    */
   private function logout()
   {
       $message = "Bye bye!";
       $this->loginView->setInfo($this->username, $message, false);
       
       $this->cookies->clearCookie(self::$usernameCookie);
       $this->cookies->clearCookie(self::$passwordCookie);
   }
   /*
    * If you have correct cookies
    */
   private function ifCookies() 
   {
       $username = $this->cookies->getCookie(self::$usernameCookie);
       $password = $this->cookies->getCookie(self::$passwordCookie);
       
       if($this->loginRules->ifCorrectLogin($username, $password))
       {
           return true;
       }
       return false;
   }
   /*
    * Initialize all objects
    */
   private function initializeObjects()
   {
       $this->dateTimeView = new DateTimeView();
       $this->layoutView = new LayoutView();
     
       $this->loginView = new LoginView();
       $this->username = $this->loginView->getUsername();
       $this->password = $this->loginView->getPassword();
       $this->loginButton = $this->loginView->isLoginButtonPushed(); 
       $this->logoutButton = $this->loginView->isLogoutButtonPushed();  
   }
}
