<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name TheFramework\Helpers\Form\Legend
 * @file Legend.php
 * @date 30-03-2013 10:52 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers\Form;
use TheFramework\Helpers\TheFrameworkHelper;

class Legend extends TheFrameworkHelper
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
    }//__construct
    
    //legend
    public function get_html()
    {  
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag(); 
        //Agrega a inner_html los valores obtenidos con get_html de cada objeto en $this->arInnerObjects
        $this->load_inner_objects();
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }//get_html
        
    public function get_opentag()
    {
        //Ejem: <fieldset> <legend>Personalia:</legend> Name: <input type="text" size="30"><br>
        $arOpenTag = array();
        $arOpenTag[] = "<$this->_type";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";
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
        //atributos extra
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        //if($this->_isPrimaryKey) $arOpenTag[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";  
        $arOpenTag[] =">";        
        return implode("",$arOpenTag);        
    }//get_opentag
    
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