<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author Daniel
 */
class Session 
{
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    public function getSession($name)
    {
        $string = "";
        if(isset($_SESSION[$name]))
        {
            $string = $this->makeStringSecure($name);
        }
        return $string;
    }
    public function generateUniqueID($username, $password)
    {
        $id = $username . "::" . $password;
        return sha1($id);  
    }
    public function destroySession()
    {
        session_destroy();
    }
    public function removeSession($name)
    {
        unset($_SESSION[$name]);
    }
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
    private function makeStringSecure($string)
    {
        $newStr = htmlentities($_SESSION[$string]);  
        return $newStr;
    }
        
}
