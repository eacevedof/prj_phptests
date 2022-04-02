<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name HelperLegend
 * @file helper_form_legend.php
 * @date 30-03-2013 10:52 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperLegend extends TheFrameworkHelper
{
    
    public function __construct($innerhtml="", $id="", $class="", $style="", $arExtras=array())
    {
        $this->_type = "legend";
        $this->_idprefix = "";
        $this->_id = $id;
        
        $this->_inner_html = $innerhtml;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
        $this->_style = $style;
    }
    
    //legend
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn = "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag(); 
        //Agrega a inner_html los valores obtenidos con get_html de cada objeto en $this->arInnerObjects
        $this->load_inner_objects();
        $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= $this->get_closetag();
        return $sHtmlToReturn;
    }
        
    public function get_opentag()
    {
        //Ejem: <fieldset> <legend>Personalia:</legend> Name: <input type="text" size="30"><br>
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
        //atributos extra
        if($this->_attr_dbfield) $sHtmlOpenTag .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlOpenTag .= " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();
        //if($this->_isPrimaryKey) $sHtmlOpenTag .= " pk=\"pk\"";
        //if($this->_attr_dbtype) $sHtmlOpenTag .= " dbtype=\"$this->_attr_dbtype\"";  
        $sHtmlOpenTag .=">";        
        return $sHtmlOpenTag;        
    }    
    
    //**********************************
    //             TO HIDE
    //**********************************
    //private function get_closetag(){;}     
    //private function get_opentag(){;}
        
    //**********************************
    //             SETS
    //**********************************
    public function set_for($value){$this->_for = $value;}

    
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}
}//HelperLegend