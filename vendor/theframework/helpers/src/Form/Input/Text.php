<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.8
 * @name TheFramework\Helpers\Form\Input\Text
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Text.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\TheFrameworkHelper;
use TheFramework\Helpers\Form\Label;

class Text extends TheFrameworkHelper
{ 
    public function __construct
    ($id="", $name="", $value="", $length=50, $class="", Label $oLabel=null)
    {
        $this->oLabel = $oLabel;
        $this->_idprefix = "";
        $this->_type = "text";
        $this->_id = $id;
        $this->_name = $name;
        $this->_value = $value;
        $this->_maxlength = $length;
        if($class) $this->arClasses[] = $class;
        $this->oLabel = $oLabel;
    }
    
    public function get_html()
    {  
        $arHtml = array();
        
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = "<input";
        if($this->_type) $arHtml[] = " type=\"$this->_type\"";
        if($this->_id) $arHtml[] = " id=\"$this->_idprefix$this->_id\"";
        if($this->_name) $arHtml[] = " name=\"$this->_idprefix$this->_name\"";
        if($this->_value || $this->_value=="0") 
            $arHtml[] = " value=\"{$this->get_cleaned($this->_value)}\"";

        //propiedades html5
        if($this->_maxlength) $arHtml[] = " maxlength=\"$this->_maxlength\"";
        if($this->_isDisabled) $arHtml[] = " disabled";
        if($this->_isReadOnly) $arHtml[] = " readonly"; 
        if($this->_isRequired) $arHtml[] = " required"; 

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
        //atributos extras pe. para usar el quryselector
        if($this->_placeholder) $arHtml[] = " placeholder=\"$this->_placeholder\"";
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
        
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_html

    //**********************************
    //             SETS
    //**********************************
    public function set_name($value){$this->_name = $value;}
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    public function set_maxlength($iNumChars){$this->_maxlength = $iNumChars;}
    public function readonly($isReadOnly=true){$this->_isReadOnly=$isReadOnly;}
    public function disabled($isDisabled=true){$this->_isDisabled=$isDisabled;}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
    public function get_maxlength(){return $this->_maxlength;}
    public function is_readonly(){return $this->_isReadOnly;}

}//class Text