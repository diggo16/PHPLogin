<?php
/**
 * Handles the UserFile
 *
 * @author Daniel
 */
class UserFile 
{
    private static $filePath = "model/data";
    /**
     * Import User.php
     */
    public function __construct() 
    {
        require_once ('User.php');
    }
    /**
     * Get an array of the existing users
     * @return array
     */
    public function getUsers() 
    {
        $users = array();
        if ($handle = opendir(self::$filePath)) 
        {
            while (false !== ($entry = readdir($handle))) 
            {

                if ($entry != "." && $entry != "..") 
                { 
                    $file = file_get_contents(self::$filePath . "/" . $entry);
                    $userInfo = explode(" ", $file);
                    $username = $userInfo[0];                   
                    $password = $userInfo[1];
                    $sessionid = $userInfo[2];
                    $cookiePassword = $userInfo[3];
                    
                    $user = new User();
                    $user->setNewInfo($username, $password, false, "");
                    $user->setSessionId($sessionid);
                    $user->setCookiePassword($cookiePassword);                   
                    $users[] = $user;
                }
            }
        closedir($handle);
        }  
        return $users;

    }
    /**
     * Replace the file with a user
     * @param var $sessionId
     * @param var $cookiePassword
     */
    public function setUserFileWithSession($sessionId, $newSession, $newCookie) //TODO Refactor methods below
    {
        $user = $this->getUserFromSession($sessionId);
        assert($user != NULL);
        $this->addUser($user->getUsername(), $user->getPassword(), $newSession, $newCookie);
    }
    public function setUserFileWithUsername($username, $newSession, $newCookie) 
    {
      $user = $this->getUserFromUsername($username);
      assert($user != NULL);
      $this->addUser($user->getUsername(), $user->getPassword(), $newSession, $newCookie);
    }
    /**
     * Add a user to the file
     * @param var $username
     * @param var $password
     * @param var $sessionId
     * @param var $cookiePassword
     */
    public function addUser($username, $password, $sessionId, $cookiePassword)
    {
        $filename = self::$filePath . "/" . $username . ".txt";
        $separator = " ";
        if($sessionId == "")
        {
            $sessionId = 0;
        }
        if($cookiePassword == "")
        {
            $cookiePassword = 0;
        }
        // Save the new content
        $fileString = $username . $separator . $password . $separator . $sessionId .
                      $separator . $cookiePassword;
        file_put_contents($filename, $fileString);    // Put the new string in the file
    }
    public function getUserFromSession($sessionId)
    {
        $users = $this->getUsers();
        foreach($users as $user)
        {
          if($user->getSessionId() == $sessionId)
          {
              return $user;
          }
        }
    }
    public function getUserFromUsername($username)
    {
        $users = $this->getUsers();
        foreach($users as $user)
        {
          if($user->getUsername() == $username)
          {
              return $user;
          }
        }
    }
}
