<?php
/**
 * Description of Session
 *
 * @author Daniel
 */
class Session 
{
    /**
     * Set the session $name to $value
     * @param string $name
     * @param string $value
     */
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    /**
     * Return the session $name
     * @param string $name
     * @return string
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
     * @param string $username
     * @param string $password
     * @return string
     */
    public function generateUniqueID($username, $password)
    {
        $id = $username . "::" . $password;
        return rand(0,10);  
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
     * @param string $name
     */
    public function removeSession($name)
    {
        unset($_SESSION[$name]);
    }
    /**
     * Check if the session exists
     * @param string $sessionName
     * @param string $sessionPassword
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
     * @param string $sessionName
     * @param string $sessionPassword
     * @param string $correctId
     * @return boolean
     */
    /*public function isSessionLoggedIn($sessionId, $correctId)
    {
        $sessionId = $this->getSession("id");
        if($correctId == "")
        {
            return false;
        }
        if($sessionId === $correctId)
        {
            return true;
        }
        return false;
        /*
        $username = $this->getSession($sessionName);
        $password = $this->getSession($sessionPassword);
        $sessionId = $this->generateUniqueID($username, $password); 
        
        if($correctId === $sessionId)
        {
            return true;
        }
        return false; */  
   // }
     /**
     * Make the string secure from unwanted html code
     * @param string $string
     * @return string
     */
    private function makeStringSecure($string)
    {
        $newStr = htmlentities($_SESSION[$string]);  
        return $newStr;
    }
        
}
