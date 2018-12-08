<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name TheFramework\Helpers\Form\Input\Generic
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Generic.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\TheFrameworkHelper;

class Generic extends TheFrameworkHelper
{
    public function __construct($value,$arExtras=array())
    {
        $this->_value = $value;
        $this->arExtras = $arExtras;
    }

    public function get_html()
    {  
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = "<input";
        if($this->_value || $this->_value=="0") 
            $arHtml[] = " value=\"{$this->get_cleaned($this->_value)}\"";
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();

        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_html
    
    //**********************************
    //             TO HIDE
    //**********************************
    //private function get_closetag(){;}     
    //private function get_opentag(){;}

    //**********************************
    //             SETS
    //**********************************
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
}//HelperGeneric