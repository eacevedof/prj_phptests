<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name TheFramework\Helpers\Html\Xl\HelperLx
 * @date 10-04-2013 14:33 (SPAIN)
* @file helper_ul_li.php
 */
namespace TheFramework\Helpers\Html\Xl;
use TheFramework\Helpers\TheFrameworkHelper;
class Lx extends TheFrameworkHelper
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
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        $this->load_inner_objects();
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }

    public function get_opentag()
    {
        $arOpenTag[] = "<$this->_type";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";
        //propiedades html5
        if($this->_isDisabled) $arOpenTag[] = " disabled";
        if($this->_isReadOnly) $arOpenTag[] = " readonly"; 
        if($this->_isRequired) $arOpenTag[] = " required"; 
        //eventos
        if($this->_js_onblur) $arOpenTag[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arOpenTag[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arOpenTag[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arOpenTag[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arOpenTag[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arOpenTag[] = " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arOpenTag[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arOpenTag[] = " style=\"$this->_style\"";
        //atributos extras
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);
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