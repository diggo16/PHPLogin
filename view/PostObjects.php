<?php
/**
 * Handles POST objects
 *
 * @author Daniel
 */
class PostObjects 
{
    /**
     * Check if the POST object is set
     * @param String $buttonName
     * @return boolean
     */
    public function isButtonPushed($buttonName) 
    {
        if(isset($_POST[$buttonName]))
        {
            return true;
        }
        return false;
    }
    /**
     * Return the string from the POST object $POSTName
     * @param String $POSTName
     * @return String
     */
    public function getString($POSTName)
    {
        return filter_input(INPUT_POST,$POSTName,FILTER_SANITIZE_STRING);
    }

}
