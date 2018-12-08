<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.1
 * @name TheFramework\Helpers\Html\ButtonBasic
 * @file ButtonBasic.php
 * @date 24-12-2016 11:28
 * @observations 
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\TheFrameworkHelper;

class ButtonBasic extends TheFrameworkHelper
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
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        //$this->load_inner_objects(); A un boton no se le puede pasar objetos embebidos
        if($this->sIcon) $arHtml[] = "<span class=\"$this->sIcon\"> </span> ";
        $arHtml[] = $this->_inner_html;
        $arHtml[] = "</button>";
        return implode("",$arHtml);
    }
        
    public function get_opentag()
    {    
        $sHtmlToReturn = "<button";
        if($this->_type) $arHtml[] = " type=\"$this->_type\"";
        if($this->_id) $arHtml[] = " id=\"$this->_idprefix$this->_id\"";
        if($this->_isDisabled) $arHtml[] = " disabled"; 
         
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        $this->load_cssclass();
        if($this->_class) $arHtml[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arHtml[] = " style=\"$this->_style\"";
        //atributos extra
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
 
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }
    
    public function set_icon($sClass){$this->sIcon=$sClass;}
}