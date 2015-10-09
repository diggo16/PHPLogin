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
     * Check for button clicks and new registration then echo the html code through LayoutView
     */
    public function showWebsite()
    {    
        $temp = $this->registerController->getTempUsername();   // new registered username
        //Change previous message
        if($temp == "")
        {
            $this->userFile->setPreviousMessage($this->user->getMessage());
        }
        // A new registration is done and should show the username in the login form
        else
        {
            $this->userFile->setPreviousMessage("");
            $this->user->setNewInfo($temp, "", false, $this->feedback->getSuccessfulRegistration());
            $this->view->setView($this->loginView->responseWithUser($this->user));
        }
        // Submit button in register form is clicked
        if($this->registerView->isSubmitButtonClicked())
        {
            $this->register();
            // Registration was successful
            if($this->registerController->isNewUser())
            {               
                header("location:?");
            }
        }
        // Register text is clicked
        if($this->registerView->isRegisterTextClicked())
        {
            $this->view->setView($this->registerView->generateRegisterForm($this->registerController->getErrorMessages($this->errors)));
            $this->errors = array();
        }
        // Get html code from LoginView depending on the users information
        else if($temp == "")
        {
            $this->view->setView($this->loginView->responseWithUser($this->user));
        }
        // Send the views and user to the LayoutView to echo the html code
        $this->layoutView->render($this->view, $this->dateTimeView, $this->registerView,$this->user);
    }
    /**
     * Change the current user
     */
    public function changeUser()
    {   
        // User has clicked log in button
        if($this->isLoggingIn())
        {
            $this->login();
        }
        // User has clicked log out button
        else if($this->isLoggingOut())
        {
            $this->isSameMessage($this->feedback->getByeMsg(), false);
            $this->loginController->logout($this->loginView->getCookieName());      // Log out the user
        }
        // If there is a correct session
        else if($this->loginController->isSessionCorrect($this->loginView->getSessionId()))
        {
            $this->user->setNewInfo("", "", true, "");
        }
        // If there is cookies
        else if($this->loginView->isCookies())
        {
            // If the cookie is correct, login the user
            if($this->loginController->authenticateCookies($this->loginView->getCookieName()))
            {
                $this->setSession();
                $this->isSameMessage($this->feedback->getWelcomeCookieMsg(), true);          
            }
            // Set error in cookies message
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
        // Get the username and password
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();
        // If the keep checkbox is checked
        if($this->loginView->isKeepChecked())
        {
            $this->user = $this->loginController->authenticateWithSavedCredentials($username, $password,  $this->loginView->getCookieName());
            $this->setSession();
        }
        // If the user don't want to save cookies
        else 
        {
            $this->user = $this->loginController->authenticate($username, $password);
            $this->setSession();
        }
        // If the user is logged in, set correct message
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
        // If the user is logged in
        if($this->user->isLoggedIn())
        {
            $sessionId = $this->user->getSessionId();
            $this->loginView->setSessionId($sessionId); 
        }   
    }
    /**
     * Check if the message is the same as the previous message.
     * If it is, clear the message
     * @param string $message
     * @param boolean $isLoggedIn
     */
    private function isSameMessage($message, $isLoggedIn)
    {
        // Clear the message if they are the same message
        if($this->userFile->getPreviousMessage() == $message)
        { 
            $this->user->setNewInfo("", "", $isLoggedIn, "");           
        }
        // Else add the message
        else
        {
            $this->user->setNewInfo("", "", $isLoggedIn, $message);
        }           
    }
}