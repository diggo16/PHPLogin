<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostObjects
 *
 * @author Daniel
 */
class PostObjects 
{
    public function isButtonPushed($buttonName) 
    {
        if(isset($_POST[$buttonName]))
        {
            return true;
        }
        return false;
    }
    public function getString($POSTName)
    {
        return filter_input(INPUT_POST,$POSTName,FILTER_SANITIZE_STRING);
    }

}
