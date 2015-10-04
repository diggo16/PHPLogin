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
    /**
     * Generate a random secure hashcode of a random number and the password
     * @param string $password
     * @return string randomString
     */
    public function generateUniqueString($password)
    {
        $salt = uniqid(mt_rand(), true);
        return sha1($password + $salt); 
    }
}
