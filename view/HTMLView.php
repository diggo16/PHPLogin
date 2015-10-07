<?php
/**
 * Description of View
 *
 * @author Daniel
 */
class HTMLView 
{
    private $htmlView;
    
    public function __construct() 
    {
        $this->htmlView = "";
    }
    public function setView($html)
    {
        $this->htmlView = $html;
    }
    public function getView()
    {
        return $this->htmlView;
    }
}
