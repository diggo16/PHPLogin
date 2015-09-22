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
    public function generateUniqueID()
    {
        return rand(0,10000000000000000000000); // random number between 0 and 10000000000000000000000  
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
