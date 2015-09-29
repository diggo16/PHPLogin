<?php
/**
 * Handles the UserFile
 *
 * @author Daniel
 */
class UserFile 
{
    private static $filename = "model/CorrectUser.txt"; // File path
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
    public function getUser() 
    {
        $users = array();
        $fileArr = file(self::$filename);   // Array of the lines in the file
        // For each line in the file
        foreach($fileArr as $line)
        {
            $userInfo = explode(" ", $line);    // Put the words in an array
            //Save the info in variables
            $username = $userInfo[0];
            $password = $userInfo[1];
            $sessionid = $userInfo[2];
            $cookiePassword = $userInfo[3];

            //Creates a new User object
            $user = new User();
            $user->setNewInfo($username, $password, false, "");
            $user->setSessionId($sessionid);
            $user->setCookiePassword($cookiePassword);
            
            array_push($users, $user);      // Push the new user to the array
        }
        return $users;    
    }
    /**
     * Replace the file with a user
     * @param var $sessionId
     * @param var $cookiePassword
     */
    public function setUserFile($sessionId, $cookiePassword)
    {
        // Stub values
        $username = "Admin";
        $password = "Password";
        // Put all the information in a string that separates the info with space
        $separator = " ";
        $fileString = $username . $separator . $password . $separator . $sessionId .
                      $separator . $cookiePassword;
        file_put_contents(self::$filename, $fileString);    // Save the string to the file
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
        $separator = " ";
        $oldString = file_get_contents(self::$filename);
        $newline = "";
        // If the file already have users
        if($oldString != "")
        {
            $newline = "\n";
        }
        // Save the new content and old if there was any
        $fileString = $oldString . $newline .$username . $separator . $password . $separator . $sessionId .
                      $separator . $cookiePassword;
        file_put_contents(self::$filename, $fileString);    // Put the new string in the file
    }
}
