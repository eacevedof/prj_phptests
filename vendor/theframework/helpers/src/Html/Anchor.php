<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name TheFramework\Helpers\Html\Anchor
 * @file Anchor.php
 * @date 30-07-2016 15:52 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\TheFrameworkHelper;

class Anchor extends TheFrameworkHelper
{
    private $_href;
    private $_target;
    
    public function __construct($innerhtml="", $id="", $href="", $target="", 
            $class="", $style="", $arExtras=array())
    {
        $this->_type = "a";
        $this->_idprefix = "";
        $this->_id = $id;
    
        $this->_href = $href;
        $this->_target = $target;
        $this->_inner_html = $innerhtml;
        
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        
        $this->arExtras = $arExtras;
    }

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
        if($this->_href) $arOpenTag[] = " href=\"$this->_href\"";
        if($this->_target) $arOpenTag[] = " target=\"$this->_target\"";
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
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] =">";        
        return implode("",$arOpenTag);
    }
    
    //**********************************
    //             SETS
    //**********************************
    public function set_href($value){$this->_href=$value;}
    public function set_target($value){$this->_target="_".$value;}


    //**********************************
    //             GETS
    //**********************************
}