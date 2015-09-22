<?php
/**
 * Description of UserFile
 *
 * @author Daniel
 */
class UserFile 
{
    private static $filename = "model/CorrectUser.txt";
    
    public function __construct() 
    {
        require_once ('User.php');
    }
    
    public function getUser() 
    {
        $fileStr = file_get_contents(self::$filename);
        $userInfo = explode(" ", $fileStr);
        $username = $userInfo[0];
        $password = $userInfo[1];
        $sessionid = $userInfo[2];
        $cookiePassword = $userInfo[3];
        
        $user = new User();
        $user->setNewInfo($username, $password, false, "");
        $user->setSessionId($sessionid);
        $user->setCookiePassword($cookiePassword);
        
        return $user;    
    }
    public function setUserFile($sessionId, $cookiePassword)
    {
        $username = "Admin";
        $password = "Password";
        $separator = " ";
        $fileString = $username . $separator . $password . $separator . $sessionId .
                      $separator . $cookiePassword;
        file_put_contents(self::$filename, $fileString);
    }
}
