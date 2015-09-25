<?php
/**
 * Description of RegisterView
 *
 * @author daniel
 */
class RegisterView 
{
    private $post;
    private static $registerText = "RegisterView::text";
    private static $register = "register";
    public function __construct() 
    {
        require_once ('PostObjects.php');
        $post = new PostObjects();
    }
    public function generateRegisterForm() 
    {
        
    }
    public function generateRegisterLink() 
    {
        $response = "<a href='?" . self::$register . "=true'>Register a new user</a>";
        return $response;
    }
    public function isRegisterTextClicked()
    {
        if($_GET[self::$register] == true)
        {
            return true;
        }
        return false;
    }
}
