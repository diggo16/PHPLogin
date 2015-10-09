<?php
/**
 * Handles the session
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
     * Destroy the session
     */
    public function destroySession()
    {
        if(session_id() != '') 
        {
            session_destroy();
        }      
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
