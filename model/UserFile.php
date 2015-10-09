<?php
/**
 * Handles the UserFile
 *
 * @author Daniel
 */
class UserFile 
{
    private static $filePath = "";
    private static $dataPath = "/../data";  // File path for local server
    private static $webhostFilePath = "/home/a6244505/data";    // file path for the server
    private static $userFilePath = "/users";
    private static $tempFilePath;
    private static $root;
    private static $messageFilePath = "/previousMessage.txt";
    
    /**
     * Import User.php
     */
    public function __construct($root) 
    {
        require_once ('User.php');
        self::$root = $root;
        self::$filePath = $root;
        self::$filePath = self::$webhostFilePath;
        self::$tempFilePath = self::$filePath . "/temp.txt";
        
        if(file_exists(self::$filePath) == false)
        {
            mkdir(self::$filePath, 0777, true);
            $userFilePath = self::$filePath . "/users";
            mkdir($userFilePath, 0777, true);
            $this->addUser("Admin", "Password", 0, 0);
        }
        if(file_exists(self::$tempFilePath) == false)
        {
            fopen(self::$tempFilePath, "w"); 
        }
    }
    /**
     * Get an array of the existing users
     * @return array
     */
    public function getUsers() 
    {
        $users = array();
        self::$filePath = self::$webhostFilePath . self::$userFilePath;   //webbserver
        //self::$filePath = self::$root . self::$dataPath . self::$userFilePath;  //local server
        // Check all files in the directory
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
    public function setUserFileWithSession($sessionId, $newSession, $newCookie)
    {
        $user = $this->getUserFromSession($sessionId);
        if($user != null)
        {
            $this->addUser($user->getUsername(), $user->getPassword(), $newSession, $newCookie);
        }       
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
    /**
     * Add the username to the temp file
     * @param string $username
     */
    public function addToTemp($username)
    {
        file_put_contents(self::$tempFilePath, $username);
    }
    /**
     * Return the username in the file temp
     * @return string tempUsername
     */
    public function getTempUsername()
    {
        return trim(file_get_contents(self::$tempFilePath)); 
    }
    /**
     * Clear the file temp
     */
    public function clearTemp()
    {
        file_put_contents(self::$tempFilePath, "");
    }
    /**
     * Set the string in the file PreviousMessage to $message
     * @param string $message
     */
    public function setPreviousMessage($message)
    {
        $filePath = self::$webhostFilePath . self::$messageFilePath;
        file_put_contents($filePath, $message);
    }
    /**
     * Get the string from the file PreviousMessage
     * @return string previousMessage
     */
    public function getPreviousMessage()
    {
        return file_get_contents($filePath = self::$webhostFilePath . self::$messageFilePath);
    }
    /**
     * Return the user with the session id $sessionId
     * @param string $sessionId
     * @return User $user
     */
    private function getUserFromSession($sessionId)
    {
        $users = $this->getUsers();
        foreach($users as $user)
        {
          if($user->getSessionId() == $sessionId)
          {
              return $user;
          }
        }
        return null;
    }
}
