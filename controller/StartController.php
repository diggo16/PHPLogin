<?php
/**
 * Description of StartController
 *
 * @author Daniel
 */
class StartController 
{
    // Views
    private $loginView;
    private $dateTimeView;
    private $registerView;
    private $layoutView;
    private $view;
    // View logic
    private $post;
    private $feedback;
    private $server;
    private $cookies;
    //model
    private $user;
    private $userFile;
    private $random;
    //controller
    private $loginController;
    private $registerController;
    
    private $errors;
    
    public function __construct(User $user, LoginController $loginController) 
    {
         //INCLUDE THE FILES NEEDED...
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        require_once('view/RegisterView.php');
        require_once('view/PostObjects.php');
        require_once('view/Feedback.php');
        require_once('model/UserFile.php');
        require_once('view/Server.php');
        require_once('view/HTMLView.php');
        require_once('controller/RegisterController.php');
        require_once('model/RandomString.php');
        require_once('view/Cookies.php');
        
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new LayoutView();
        $this->post = new PostObjects();
        $this->feedback = new Feedback();
        $this->server = new Server();
        $this->view = new HTMLView();
        $this->cookies = new Cookies();
        //Create objects of the model
        $this->user = $user;
        $this->userFile = new UserFile($this->server->getDocumentRootPath());
        $this->random = new RandomString();
        //controllers
        $this->loginController = $loginController;
        $this->registerController = new RegisterController();
        
        $this->errors = array();
    }
    /**
     * Show the website
     */
    public function showWebsite()
    {    
        $temp = $this->registerController->getTempUsername();   // new registered username
        //Change previous message
        if($temp == "")
        {
            $this->userFile->setPreviousMessage($this->user->getMessage());
        }
        else
        {
            $this->userFile->setPreviousMessage("");
            $this->user->setNewInfo($temp, "", false, $this->feedback->getSuccessfulRegistration());
            $this->view->setView($this->loginView->responseWithUser($this->user));
        }
        if($this->registerView->isSubmitButtonClicked())
        {
            $this->register();
            if($this->registerController->isNewUser())
            {               
                header("location:?");
            }
        }
        if($this->registerView->isRegisterTextClicked())
        {
            $this->view->setView($this->registerView->generateRegisterForm($this->registerController->getErrorMessages($this->errors)));
            $this->errors = array();
        }
        else if($temp == "")
        {
            $this->view->setView($this->loginView->responseWithUser($this->user));
        }
        $this->layoutView->newRender($this->view, $this->dateTimeView, $this->registerView,$this->user);
    }
    /**
     * Change the current user
     */
    public function changeUser()
    {       
        if($this->isLoggingIn())
        {
            $this->login();
        }
        else if($this->isLoggingOut())
        {
            if($this->userFile->getPreviousMessage() == $this->feedback->getByeMsg())
            { 
                $this->user->setNewInfo("", "", false, "");
                $this->loginController->logout($this->loginView->getCookieName());                
            }
            else
            {
                $this->user->setNewInfo("", "", false, $this->feedback->getByeMsg());
                $this->loginController->logout($this->loginView->getCookieName()); 
            }           
        }
        else if($this->loginController->isSessionCorrect($this->loginView->getSessionId()))
        {
            $this->user->setNewInfo("", "", true, "");
        }
        else if($this->loginView->isCookies())
        {
            if($this->loginController->authenticateCookies($this->loginView->getCookieName()))
            {
                $this->setSession();
                if($this->userFile->getPreviousMessage() == $this->feedback->getWelcomeCookieMsg())
                { 
                    $this->user->setNewInfo("", "", true, "");           
                }
                else
                {
                    $this->user->setNewInfo("", "", true, $this->feedback->getWelcomeCookieMsg());
                }           
            }
            else
            {
                $this->user->setNewInfo("", "", false, $this->feedback->getWrongInformationCookies());        
            }
        }
    }
    /**
     * Register new user
     */
    public function register()
    {
        $username = $this->registerView->getUsername();
        $password = $this->registerView->getPassword();
        $this->errors = $this->registerController->registerUser($username, $password, $this->registerView->getRepeatPassword());     
    }
    /**
     * Check if the user is trying to log in
     * @return boolean isLoggingIn
     */
    private function isLoggingIn()
    {
        return $this->loginView->isLoggedInButtonPushed();
    }
    /**
     * Check if the user is logging out
     * @return boolean
     */
    private function isLoggingOut()
    {
        return $this->loginView->isLoggedOutButtonPushed();
    }
    /**
     * Try to log in the user
     */
    private function login()
    {
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();
        if($this->loginView->isKeepChecked())
        {
            $this->user = $this->loginController->authenticateWithSavedCredentials($username, $password,  $this->loginView->getCookieName());
            if($this->user->isLoggedIn())
            {
                $this->user->setMessage($this->feedback->getWelcomeAndRemembered());
            }
            $this->setSession();
        }
        else 
        {
            $this->user = $this->loginController->authenticate($username, $password);
            $this->setSession();
        }
        if($this->user->isLoggedIn())
        {
            if($this->userFile->getPreviousMessage() != $this->feedback->getWelcomeMsg())
            {
                if($this->loginView->isKeepChecked())
                {
                    $message = $this->feedback->getWelcomeAndRemembered();
                }
                else
                {
                    $message = $this->feedback->getWelcomeMsg();
                }
                $this->user->setMessage($message);
            }            
        }
    }
    /**
     * Set session id if the user is logged in
     */
    private function setSession()
    {
        if($this->user->isLoggedIn())
        {
            $sessionId = $this->user->getSessionId();
            $this->loginView->setSessionId($sessionId); 
        }   
    }
}