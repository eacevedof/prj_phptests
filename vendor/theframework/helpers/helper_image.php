<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.5
 * @name HelperImage
 * @date 06-06-2014 10:2
 * @file helper_image.php
 * @observations:
 * @requires: 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperImage extends TheFrameworkHelper
{
    protected $_src;
    protected $_alt;
    protected $_title;

    public function __construct($src="", $id="", $class="", $style="", $arExtras=array())
    {
        $this->_type = "img";
        $this->_idprefix = "";
        $this->_id = $id;
        
        $this->_src = $src;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }
    
    //Fieldset
    public function get_html()
    {  
        $sHtmlToReturn = "<$this->_type";
        if($this->_src) $sHtmlToReturn .= " src=\"$this->_src\"";
        if($this->_alt) $sHtmlToReturn .= " alt=\"$this->_alt\"";
        if($this->_title) $sHtmlToReturn .= " title=\"$this->_title\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        //eventos
        if($this->_js_onblur) $sHtmlToReturn .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlToReturn .= " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $sHtmlToReturn .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $sHtmlToReturn .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlToReturn .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlToReturn .= " onmouseout=\"$this->_js_onmouseout\"";        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlToReturn .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlToReturn .= " style=\"$this->_style\"";
        //atributos extra
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        //if($this->_isPrimaryKey) $sHtmlOpenTag .= " pk=\"pk\"";
        //if($this->_attr_dbtype) $sHtmlOpenTag .= " dbtype=\"$this->_attr_dbtype\"";  
        $sHtmlToReturn .=">";        
        return $sHtmlToReturn;
    }
        
        
    //**********************************
    //             SETS
    //**********************************
    public function set_src($sUrl){$this->_src = $sUrl;}
    public function set_alt($value){$this->_alt = $value;}
    public function set_title($value){$this->_title = $value;}
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}
    
}