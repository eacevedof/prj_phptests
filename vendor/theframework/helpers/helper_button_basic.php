<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.1
 * @name HelperButtonBasic
 * @file helper_button_basic.php
 * @date 24-12-2016 11:28
 * @observations 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;

class HelperButtonBasic extends TheFrameworkHelper
{
    protected $sIcon;
    
    public function __construct($id="", $innerhtml="")
    {
        //tiene que ser button sino hay tipo ejecuta un submit
        $this->_type = "button";
        $this->_idprefix="";
        $this->_id = $id;
        $this->_inner_html = $innerhtml;
    }
    
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn = "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        //$this->load_inner_objects(); A un boton no se le puede pasar objetos embebidos
        if($this->sIcon) $sHtmlToReturn .= "<span class=\"$this->sIcon\"> </span> ";
        $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= "</button>";
        return $sHtmlToReturn;
    }
        
    public function get_opentag()
    {    
        $sHtmlToReturn = "<button";
        if($this->_type) $sHtmlToReturn .= " type=\"$this->_type\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        if($this->_isDisabled) $sHtmlToReturn .= " disabled"; 
         
        if($this->_js_onblur) $sHtmlToReturn .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlToReturn .= " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $sHtmlToReturn .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $sHtmlToReturn .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlToReturn .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlToReturn .= " onmouseout=\"$this->_js_onmouseout\"";
        
        $this->load_cssclass();
        if($this->_class) $sHtmlToReturn .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlToReturn .= " style=\"$this->_style\"";
        //atributos extra
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
 
        $sHtmlToReturn .= ">\n";
        return $sHtmlToReturn;
    }
    
    public function set_icon($sClass){$this->sIcon=$sClass;}
}