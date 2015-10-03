<?php
/**
 * Description of Server
 *
 * @author daniel
 */
class Server 
{
    public function getDocumentRootPath()
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        return $documentRoot;        
    }
}
