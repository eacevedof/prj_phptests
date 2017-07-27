<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name HelperRaw
 * @date 06-12-2016 14:38
 * @file helper_raw.php
 * @requires
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperRaw extends TheFrameworkHelper
{
    
    public function __construct($sRawHtml="")
    {
        $this->_inner_html = $sRawHtml;
    }
    
    //Raw
    public function get_html()
    {  
        //Agrega a inner_html los valores obtenidos con get_html
        $sHtmlToReturn = "";
        $this->load_inner_objects();
        $sHtmlToReturn .= $this->_inner_html;
        return $sHtmlToReturn;
    }
    
    //Escondo este metodo
    public function set_rawhtml($sRawHtml,$asEntity=0){parent::set_innerhtml($sRawHtml,$asEntity);}
    
    //**********************************
    //             SETS
    //**********************************
    
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
}