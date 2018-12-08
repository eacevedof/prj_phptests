<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.4.0
 * @name TheFramework\Helpers\Form\Form
 * @file Form.php
 * @date 30-04-2016 07:22 (SPAIN)
 * @observations: core library
 */
namespace TheFramework\Helpers\Form;

use TheFramework\Helpers\TheFrameworkHelper;

class Form extends TheFrameworkHelper
{
    private $_method;
    private $_enctype;
    private $_action;
    private $_js_onsubmit;
    
    private $oFieldset;
    private $oLegend;

    public function __construct($id="", $name="", $method="post", $innerhtml=""
            , $action="", $class="", $style="", $arExtras=array(), $enctype="", $onsubmit="")
    {
        //enctype="multipart/form-data"
        $this->_type = "form";
        $this->_idprefix = "";
        $this->_id = $id;
        $this->_name = $name;
        $this->_inner_html = $innerhtml;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        
        $this->arExtras = $arExtras;
        $this->_method = $method;
        $this->_action = $action;
        $this->_enctype = $enctype;
        $this->_js_onsubmit = $onsubmit;
    }

    public function get_html()
    {  
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";       
        $arHtml[] = $this->get_opentag();
        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_opentag();
        if($this->oLegend) $arHtml[] = $this->oLegend->get_opentag();
        //Agrega a inner_html los valores obtenidos con get_html de cada objeto
        $this->load_inner_objects();
        if($this->_inner_html)$arHtml[] = "$this->_inner_html\n";
        if($this->oLegend) $arHtml[] = $this->oLegend->get_closetag();
        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_closetag();
        $arHtml[] = $this->get_closetag();

        return implode("",$arHtml);
    }//get_html
    
    protected function load_inner_objects()
    {
        foreach($this->arInnerObjects as $oObject)
            //este objeto suele ser el wrapper
            if(method_exists($oObject,"get_html"))
            {
                if($this->_isReadOnly)
                {
                    if(method_exists($oObject,"readonly"))
                    {   
                        $oObject->readonly();
                        $oObject->add_class("readonly");
                    }
                }
                $this->_inner_html .= $oObject->get_html();
            }
            elseif(is_string($mxValue))
                $this->_inner_html .= $mxValue;
    }//load_inner_objects
    
    public function get_opentag()
    {
        $arOpenTag = array();
        $arOpenTag[] = "<$this->_type";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";

        //eventos
        if($this->_js_onblur) $arOpenTag[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arOpenTag[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress)$arOpenTag[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onfocus) $arOpenTag[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onsubmit) $arOpenTag[] = " onsubmit=\"$this->_js_onsubmit\"";
        if($this->_js_onmouseover) $arOpenTag[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arOpenTag[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        //propios del formulario
        if($this->_method) $arOpenTag[] = " method=\"$this->_method\"";
        if($this->_action) $arOpenTag[] = " action=\"$this->_action\"";
        if($this->_enctype) $arOpenTag[] = " enctype=\"$this->_enctype\"";
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arOpenTag[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arOpenTag[] = " style=\"$this->_style\"";
        //atributos extra
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();

        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function set_legend(HelperLegend $oLegend){$this->oLegend = $oLegend;}
    public function set_fieldset(HelperFieldset $oFieldset){$this->oFieldset = $oFieldset;}
    public function set_method($value){$this->_method = $value;}
    public function set_action($value){$this->_action = $value;}
    public function set_enctype($value){$this->_enctype = $value;}
    public function set_js_onsubmit($value){$this->_js_onsubmit=$value;}
    public function add_controltop($oHelper){if($oHelper) array_unshift($this->arInnerObjects,$oHelper);}
    public function add_control($oHelper){$this->arInnerObjects[]=$oHelper;}
    public function add_controls($arObjControls){$this->arInnerObjects=$arObjControls;}
    public function readonly($isReadOnly = true){$this->_isReadOnly = $isReadOnly;}
    //**********************************
    //             GETS
    //**********************************

    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}

}//HelperForm