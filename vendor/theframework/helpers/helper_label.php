<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name HelperLabel
 * @date 09-01-2017 12:55 (SPAIN)
 * @file helper_label.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperLabel extends TheFrameworkHelper
{
    private $_for = "";
    
    public function __construct($for="", $innerhtml="", $id="", 
            $class="", $style="", $arExtras=array())
    {
        $this->_type = "label";
        $this->_idprefix = "";
        $this->_id = $id;
        
        $this->_inner_html = $innerhtml;
        $this->_for = $for;
        //$this->arClasses[] = "control-label";
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }
    
    //label
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn = "<!-- $this->_comments -->\n";        
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
        if($this->_for) $sHtmlOpenTag .= " for=\"$this->_for\"";
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
    public function set_for($value){$this->_for = $value;}
    //**********************************
    //             GETS
    //**********************************
    public function get_for(){return $this->_for;}
}//HelperLabel