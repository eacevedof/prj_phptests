<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name HelperRadio
 * @date 15-07-2013 19:51
 * @file helper_radio.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperRadio extends TheFrameworkHelper
{
    private $_arOptions;
    private $_value_to_check;
   
    //private $_name;
    private $_legendtext;
    //private $_inFieldsetDiv=true;
    
    public function __construct($arOptions, $grpname, $legendtext="", $valuetocheck="", $class="", $arExtras=array())
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
        $sHtmlToReturn ="";
        //$sHtmlFieldSet = "<fieldset>\n";
        //$sHtmlFieldSetEnd = "</fieldset>\n";
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        if($this->_legendtext) $sHtmlToReturn .= "<legend>$this->_legendtext</legend>\n";

        $i=0;
        foreach($this->_arOptions as $sValue => $sLabel)
        {
            $isChecked = ($this->_value_to_check == $sValue);
            $id = $this->_idprefix.$this->_name."_".$i;
            $id = str_replace("[]","",$id);
            $oLabel = new HelperLabel($id, $sLabel, "lbl$id");
            $sHtmlToReturn .= $this->build_input_radio($id, $sValue, $oLabel, $isChecked);
            $i++;            
        }
        //if($this->_inFieldsetDiv) $sHtmlToReturn = $sHtmlFieldSet.$sHtmlToReturn.$sHtmlFieldSetEnd;
        return $sHtmlToReturn;
    }

    private function build_input_radio($id, $value, HelperLabel $oLabel=null, $isChecked=false)
    {
        $this->_id = $id;
        
        $sHtmlToReturn ="";
        $sHtmlToReturn .= "<input";
        if($this->_type) $sHtmlToReturn .= " type=\"$this->_type\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$id\"";
        if($this->_name) $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name\"";
        if($value) $sHtmlToReturn .= " value=\"$value\"";
        if($isChecked) $sHtmlToReturn .= " checked" ;
        //propiedades html5
        //if($this->_maxlength)$sHtmlToReturn .= " maxlength=\"$this->_maxlength\"";
        if($this->_isDisabled) $sHtmlToReturn .= " disabled";
        if($this->_isReadOnly) $sHtmlToReturn .= " readonly"; 
        //if($this->_isRequired) $sHtmlToReturn .= " required"; 
        //eventos
        if($this->_js_onblur) $sHtmlToReturn .= " onblur=\"$this->_js_onblur\"";

        if($this->_js_onchange && $this->_isPostback) 
            $sHtmlToReturn .= " onchange=\"$this->_js_onchange;postback(this);\"";
        elseif($this->_js_onchange)$sHtmlToReturn .= " onchange=\"$this->_js_onchange\"";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isPostback) $sHtmlToReturn .= " onchange=\"postback(this);\"";
        
        if($this->_js_onclick) $sHtmlToReturn .= " onclick=\"$this->_js_onclick\"";
        
        if($this->_js_onkeypress && $this->_isEnterInsert) 
            $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress;onenter_insert(event);\"";
        elseif($this->_js_onkeypress && $this->_isEnterUpdate)
            $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress;onenter_update(event);\"";
        elseif($this->_js_onkeypress && $this->_isEnterSubmit)
            $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress;onenter_submit(event);\"";
        elseif($this->_js_onkeypress) $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress\"";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isEnterInsert) $sHtmlToReturn .= " onkeypress=\"onenter_insert(event);\"";
        elseif($this->_isEnterUpdate) $sHtmlToReturn .= " onkeypress=\"onenter_update(event);\"";
        elseif($this->_isEnterSubmit) $sHtmlToReturn .= " onkeypress=\"onenter_submit(event);\"";
        
        if($this->_js_onfocus) $sHtmlToReturn .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlToReturn .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlToReturn .= " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlToReturn .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlToReturn .= " style=\"$this->_style\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        $sHtmlToReturn .= " />\n";
        if($oLabel) $sHtmlToReturn .= $oLabel->get_html();

        return $sHtmlToReturn;
    }    

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