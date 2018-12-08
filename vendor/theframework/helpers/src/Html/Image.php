<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.5
 * @name TheFramework\Helpers\Html\Image
 * @date 06-06-2014 10:2
 * @file Image.php
 * @observations:
 * @requires: 
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\TheFrameworkHelper;
class Image extends TheFrameworkHelper
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
        if($this->_src) $arHtml[] = " src=\"$this->_src\"";
        if($this->_alt) $arHtml[] = " alt=\"$this->_alt\"";
        if($this->_title) $arHtml[] = " title=\"$this->_title\"";
        if($this->_id) $arHtml[] = " id=\"$this->_idprefix$this->_id\"";
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arHtml[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arHtml[] = " style=\"$this->_style\"";
        //atributos extra
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
        //if($this->_isPrimaryKey) $arOpenTag[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";  
        $sHtmlToReturn .=">";        
        return implode("",$arHtml);
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