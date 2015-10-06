<?php
/**
 * Description of StartController
 *
 * @author Daniel
 */
class StartController 
{
    private $loginView;
    private $dateTimeView;
    private $registerView;
    private $layoutView;
    
    public function __construct() 
    {
         //INCLUDE THE FILES NEEDED...
        require_once('view/LoginView.php');
        require_once('view/DateTimeView.php');
        require_once('view/LayoutView.php');
        require_once ('view/RegisterView.php');
        
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new LayoutView();
    }
    public function showWebsite()
    {
        $this->layoutView->render($this->loginView, $this->dateTimeView, $this->registerView);
    }
}
