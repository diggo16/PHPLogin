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
    //model
    private $user;
    private $userFile;
    //controller
    private $loginController;
    private $registerController;
    
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
        
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new LayoutView();
        $this->post = new PostObjects();
        $this->feedback = new Feedback();
        $this->server = new Server();
        $this->view = new HTMLView();
        //Create objects of the model
        $this->user = $user;
        $this->userFile = new UserFile($this->server->getDocumentRootPath());
        //controllers
        $this->loginController = $loginController;
        $this->registerController = new RegisterController();
    }
    /**
     * Show the website
     */
    public function showWebsite()
    {    
        $temp = $this->registerController->getTempUsername();
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
            if($this->registerController->isTempUsernameExist())
            {               
                header("location:?");
            }
        }
        if($this->registerView->isRegisterTextClicked())
        {
            $this->view->setView($this->registerView->generateRegisterForm());
        }
        else if($temp == "")
        {
            $this->view->setView($this->loginView->responseWithUser($this->user));
        }
        
        $this->layoutView->newRender($this->view, $this->dateTimeView, $this->registerView,$this->user);
    }
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
                $this->loginController->logout("", "", "", $this->loginView->getCookieName());                
            }
            else
            {
                $this->user->setNewInfo("", "", false, $this->feedback->getByeMsg());
                $this->loginController->logout("", "", "", $this->loginView->getCookieName()); 
            }
            
        }
        else if($this->loginController->isSessionCorrect($this->loginView->getSessionId()))
        {
            $this->user->setNewInfo("", "", true, "");
        }
        else if($this->loginView->isCookies())
        {
            
        }
    }
    public function register()
    {
        $username = $this->registerView->getUsername();
        $password = $this->registerView->getPassword();
        $errors = $this->registerController->registerUser($username, $password, $this->registerView->getRepeatPassword());
        if(count($errors) == 0)
        {
            header("location: ?");
        }
        
    }
    private function isLoggingIn()
    {
        return $this->loginView->isLoggedInButtonPushed();
    }
    private function isLoggingOut()
    {
        return $this->loginView->isLoggedOutButtonPushed();
    }
    private function login()
    {

        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();
        if($this->loginView->isKeepChecked())
        {
            $this->user = $this->loginController->authenticateWithSavedCredentials($username, $password, "", $this->loginView->getCookieName());
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
                $this->user->setMessage($this->feedback->getWelcomeMsg());
            }            
        }
        
        
    }
    private function setSession()
    {
        if($this->user->isLoggedIn())
        {
            $sessionId = $this->user->getSessionId();
            $this->loginView->setSessionId($sessionId); 
        }   
    }
}
