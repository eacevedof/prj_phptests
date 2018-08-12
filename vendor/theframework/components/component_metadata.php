<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentMetadata
 * @file component_metadata.php
 * @version 1.0.0
 * @date 30-06-2018 12:39
 * @observations
 */
namespace TheFramework\Components;

class ComponentMetadata 
{
    public function __construct() 
    {
        
    }
       
    public function go()
    {
        echo "ComponentMetadata.go :)";
    }
    
    public function debug($mxVar){echo var_export($mxVar,1)."\n";}
    
}//ComponentMetadata