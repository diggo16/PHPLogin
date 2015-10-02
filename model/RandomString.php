<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RandomString
 *
 * @author Daniel
 */
class RandomString 
{
    private $salt;
    public function construct()
    {
        $this->salt = uniqid(mt_rand(), true);
    }
    public function generateUniqueString($password)
    {
        return sha1($password + $this->salt); 
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
}
