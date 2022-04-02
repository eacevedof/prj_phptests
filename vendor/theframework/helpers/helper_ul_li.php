<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name HelperUlLi
 * @date 10-04-2013 14:33 (SPAIN)
* @file helper_ul_li.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperUlLi extends TheFrameworkHelper
{  
    public function __construct($id="", $innerhtml="")
    {
        $this->_idprefix = "li";
        $this->_type = "li";
        $this->_id = $id;
        $this->_inner_html = $innerhtml;
    }
    
    //li
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        $this->load_inner_objects();
        $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= $this->get_closetag();
        return $sHtmlToReturn;
    }

    public function get_opentag()
    {
        $sHtmlOpenTag = "<$this->_type";
        if($this->_id) $sHtmlOpenTag .= " id=\"$this->_idprefix$this->_id\"";
        //propiedades html5
        if($this->_isDisabled) $sHtmlOpenTag .= " disabled";
        if($this->_isReadOnly) $sHtmlOpenTag .= " readonly"; 
        if($this->_isRequired) $sHtmlOpenTag .= " required"; 
        //eventos
        if($this->_js_onblur) $sHtmlOpenTag .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlOpenTag .= " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $sHtmlOpenTag .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $sHtmlOpenTag .= " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $sHtmlOpenTag .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlOpenTag .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlOpenTag .= " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlOpenTag .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlOpenTag .= " style=\"$this->_style\"";
        //atributos extras
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();
        $sHtmlOpenTag .=">\n";
        return $sHtmlOpenTag;
    }    
    
    //**********************************
    //             SETS
    //**********************************
    //public function set_array_items($arItems=array()){$this->_arItems = $arItems;}
    
    //**********************************
    //             GETS
    //**********************************
    //public function get_array_li(){return $this->_arItems;}
}