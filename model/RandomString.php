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
        $this->salt = uniqid(mt_rand(), true);
        return sha1($password + $this->salt); 
    }
}
