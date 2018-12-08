<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name TheFramework\Helpers\Html\Xl\Xl
 * @date 06-09-2013 16:58 (SPAIN)
 * @file helper_ul.php
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\TheFrameworkHelper;
class Xl extends TheFrameworkHelper
{
    protected $arObjLi;
  
    public function __construct
    ($id, $innerhtml="", $arObjLi=array())
    {
        $this->_idprefix = "";
        $this->_type = "ul";
        $this->_id = $id;
        $this->_inner_html = $innerhtml;
        $this->arObjLi = $arObjLi;
    }
    
    public function get_html()
    {  
        $arHtml = array();
        if(!$this->_inner_html) $this->_inner_html = $this->get_array_li_as_string();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag();
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }

    private function get_array_li_as_string()
    {
        $sLi = "";
        foreach($this->arObjLi as $oLi) 
            if(is_object($oLi))
                $sLi .= $oLi->get_html();
            elseif(is_string($oLi)) 
                $sLi .= $oL;

        return $sLi;
    }
        
    public function get_opentag()
    {
        $arOpenTag[] = "<$this->_type";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";
        //propiedades html5
        if($this->_isDisabled) $arOpenTag[] = " disabled";
        if($this->_isReadOnly) $arOpenTag[] = " readonly"; 
        if($this->_isRequired) $arOpenTag[] = " required"; 
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
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        //if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";
        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);
    }    

    //**********************************
    //             SETS
    //**********************************
    public function set_array_li($arObjLi){$this->arObjLi = $arObjLi;}
    
    
    //**********************************
    //             GETS
    //**********************************
    public function get_array_li(){return $this->arObjLi;}
}
?>