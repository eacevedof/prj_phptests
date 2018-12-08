<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name TheFramework\Helpers\Form\Input\Radio
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Radio.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\TheFrameworkHelper;
use TheFramework\Helpers\Form\Label;

class Radio extends TheFrameworkHelper
{
    private $_arOptions;
    private $_value_to_check;
    private $_legendtext;
    
    public function __construct($arOptions, $grpname, $legendtext=""
            , $valuetocheck="", $class="", $arExtras=array())
    {
        //$this->_id = ""; el id se aplica por check no por legend
        $this->_type = "radio";
        $this->_idprefix="";
        $this->_arOptions = $arOptions;
        $this->_value_to_check = $valuetocheck;
       
        $this->_name = $grpname;
        $this->_legendtext = $legendtext;
        if($class) $this->arClasses[] = $class;
        $this->arExtras = $arExtras;
    }

    public function get_html()
    {  
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        if($this->_legendtext) $arHtml[] = "<legend>$this->_legendtext</legend>\n";

        $i=0;
        foreach($this->_arOptions as $sValue => $sLabel)
        {
            $isChecked = ($this->_value_to_check == $sValue);
            $id = $this->_idprefix.$this->_name."_".$i;
            $id = str_replace("[]","",$id);
            $oLabel = new Label($id, $sLabel, "lbl$id");
            $arHtml[] = $this->build_input_radio($id, $sValue, $oLabel, $isChecked);
            $i++;            
        }
        //if($this->_inFieldsetDiv) $sHtmlToReturn = $sHtmlFieldSet.$sHtmlToReturn.$sHtmlFieldSetEnd;
        return implode("",$arHtml);
    }//get_html

    private function build_input_radio($id, $value, Label $oLabel=null, $isChecked=false)
    {
        $this->_id = $id;
        $arHtml = array();
        $arHtml[] = "<input";
        if($this->_type) $arHtml[] = " type=\"$this->_type\"";
        if($this->_id) $arHtml[] = " id=\"$id\"";
        if($this->_name) $arHtml[] = " name=\"$this->_idprefix$this->_name\"";
        if($value) $arHtml[] = " value=\"$value\"";
        if($isChecked) $arHtml[] = " checked" ;
        //propiedades html5
        //if($this->_maxlength)$arHtml[] = " maxlength=\"$this->_maxlength\"";
        if($this->_isDisabled) $arHtml[] = " disabled";
        if($this->_isReadOnly) $arHtml[] = " readonly"; 
        //if($this->_isRequired) $arHtml[] = " required"; 
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange)$arHtml[] = " onchange=\"$this->_js_onchange\"";
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
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
        $arHtml[] = " />\n";
        if($oLabel) $arHtml[] = $oLabel->get_html();

        return implode("",$arHtml);
    }//build_input_radio

    //**********************************
    //             SETS
    //**********************************
    public function set_name($value){$this->_name = $value;}
    public function set_value_to_check($value){$this->_value_to_check = $value;}
    public function set_legendtext($value){$this->_legendtext = $value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    public function get_value_checked(){return $this->_value_to_check;}
    public function get_legendtext(){return $this->_legendtext;}
}
/*<form>
  <fieldset>
    <legend>Personalia:</legend> The <legend> tag defines a caption for the <fieldset> element.
    Name: <input type="text" size="30"><br>
    Email: <input type="text" size="30"><br>
    Date of birth: <input type="text" size="10">
  </fieldset>
</form>
 * 
<form ...>
    <input type="radio" name="creditcard" value="Visa" id="visa" />
    <label for="visa">Visa</label>
    <input type="radio" name="creditcard" value="Mastercard" id="mastercard" />
    <label for="mastercard">Mastercard</label>
</form>
 */