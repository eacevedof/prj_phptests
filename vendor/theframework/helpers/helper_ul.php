<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name HelperUl
 * @date 06-09-2013 16:58 (SPAIN)
 * @file helper_ul.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperUl extends TheFrameworkHelper
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
        $sHtmlToReturn = "";
        if(!$this->_inner_html) $this->_inner_html = $this->get_array_li_as_string();
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag();
        $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= $this->get_closetag();
        return $sHtmlToReturn;
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
        $sHtmlOpenTag = "<$this->_type";
        if($this->_id) $sHtmlOpenTag .= " id=\"$this->_idprefix$this->_id\"";
        //propiedades html5
        if($this->_isDisabled) $sHtmlOpenTag .= " disabled";
        if($this->_isReadOnly) $sHtmlOpenTag .= " readonly"; 
        if($this->_isRequired) $sHtmlOpenTag .= " required"; 
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
        //atributos extras
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();
        //if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        //if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";
        $sHtmlOpenTag .=">\n";
        return $sHtmlOpenTag;
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