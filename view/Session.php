<?php
/**
 * Handles session objects
 *
 * @author Daniel
 */
class Session 
{
    /**
     * Set the session $name to $value
     * @param String $name
     * @param String $value
     */
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    /**
     * Return the session $name
     * @param String $name
     * @return String
     */
    public function getSession($name)
    {
        $string = "";
        if(isset($_SESSION[$name]))
        {
            $string = $this->makeStringSecure($name);
        }
        return $string;
    }
    /**
     * Generate an unique id of the $username and $password
     * @param String $username
     * @param String $password
     * @return String
     */
    public function generateUniqueID($username, $password)
    {
        $id = $username . "::" . $password;
        return sha1($id);  
    }
    /**
     * Destroy the session
     */
    public function destroySession()
    {
        session_destroy();
    }
    /**
     * Remove the session $name
     * @param String $name
     */
    public function removeSession($name)
    {
        unset($_SESSION[$name]);
    }
    /**
     * Check if the session exists
     * @param String $sessionName
     * @param String $sessionPassword
     * @return boolean
     */
    public function isSessionExist($sessionName, $sessionPassword)
    {
        $username = $this->getSession($sessionName);
        $password = $this->getSession($sessionPassword);
      
        if($username !== "" && $password !== "")
        {
            return true;
        }
        return false;
    }
    /**
     * Check if the session is logged in
     * @param String $sessionName
     * @param String $sessionPassword
     * @param String $correctId
     * @return boolean
     */
    public function isSessionLoggedIn($sessionName, $sessionPassword, $correctId)
    {
        $username = $this->getSession($sessionName);
        $password = $this->getSession($sessionPassword);
        $sessionId = $this->generateUniqueID($username, $password); 
        
        if($correctId === $sessionId)
        {
            return true;
        }
        return false;   
    }
    /**
     * Make the string secure from unwanted html code
     * @param String $string
     * @return String
     */
    private function makeStringSecure($string)
    {
        $newStr = htmlentities($_SESSION[$string]);  
        return $newStr;
    }
        
}
