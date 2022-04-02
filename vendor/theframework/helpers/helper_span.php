<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.0
 * @name Helper Span
 * @date 08-01-2017 12:40
 * @file helper_span.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperSpan extends TheFrameworkHelper
{    
    public function __construct($innerhtml="", $id="", 
            $class="", $style="", $arExtras=array())
    {
        $this->_type = "span";
        $this->_idprefix = "";
        $this->_id = $id;
        
        $this->_inner_html = $innerhtml;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }
    
    //span
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn = "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag(); 
        $this->load_inner_objects();
        $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= $this->get_closetag();
        return $sHtmlToReturn;
    }
        
    public function get_opentag()
    {
        $sHtmlOpenTag = "<$this->_type";
        if($this->_id) $sHtmlOpenTag .= " id=\"$this->_idprefix$this->_id\"";
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
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $sHtmlOpenTag .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlOpenTag .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $sHtmlOpenTag .= " pk=\"pk\"";
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();

        $sHtmlOpenTag .=">";        
        return $sHtmlOpenTag;        
    }    
    //**********************************
    //             SETS
    //**********************************
    //**********************************
    //             GETS
    //**********************************
}