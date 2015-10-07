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
    // View logic
    private $post;
    //model
    private $user;
    //controller
    private $loginController;
    
    public function __construct(User $user, LoginController $loginController) 
    {
         //INCLUDE THE FILES NEEDED...
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        require_once('view/RegisterView.php');
        require_once('view/PostObjects.php');
        
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new LayoutView();
        $this->post = new PostObjects();
        //Create objects of the model
        $this->user = $user;
        $this->loginController = $loginController;
    }
    public function showWebsite()
    { 
        $this->layoutView->newRender($this->loginView, $this->dateTimeView, $this->registerView, $this->user);
    }
    public function changeUser()
    {
        
        if($this->isLoggingIn())
        {
            $this->login();
        }
        else if($this->isLoggingOut())
        {
            $this->user->setNewInfo("", "", false, "Bye bye!");
            $this->loginController->logout("", "", "", $this->loginView->getCookieName());
        }
        else if($this->loginController->isSessionCorrect($this->loginView->getSessionId()))
        {
            $this->user->setNewInfo("", "", true, "Welcome");
        }
        else if($this->loginView->isCookies())
        {
            echo "cookies";
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
        $this->user = $this->loginController->authenticate($username, $password);
        $this->setSession();
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
