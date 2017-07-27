<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.13
 * @name HelperDate
 * @file helper_input_date.php
 * @date 21-11-2016 09:08 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperDate extends TheFrameworkHelper
{
    private $_useClearButton = true;
    private $_convert_date_before_show = true;
    private $isIpadIphone;
    private $cSeparator;

    public function __construct
    ($id="", $name="", $value="", $arExtras=array(), $maxlength="", $class="", HelperLabel $oLabel=NULL)
    {
        //$this->_type = "date";
        $this->_type = "text";//12/11/2013 lo cambio a text pq el tipo date en dispositivos moviles no se comporta como se desea
        $this->_idprefix = "";//dtb
        $this->cSeparator = "/";
        $this->_id = $id;
        $this->_value = $value;
        $this->_maxlength  = $maxlength;
        $this->_name = $name;
        if($class) $this->arClasses[] = $class;        
        $this->arExtras = $arExtras;
        $this->oLabel = $oLabel;        
    }

    private function to_user_date($sAnyDate)
    {
        $sUserDate = "";
        $sAnyDate = trim($sAnyDate);
        if($sAnyDate)
        {
            $sAnyDate = str_replace(" ","",$sAnyDate);
            if(strstr($sAnyDate,"/"))
               $cSep = "/";
            elseif(strstr($sAnyDate,"-"))
                $cSep = "-";
            //si tiene formato hydra
            if(!$cSep)
            {
                $cSep = $this->cSeparator;
                //bug($sHydraDate); die; 2001 10 25
                $sYear = substr($sAnyDate,0,4);
                $sMonth = substr($sAnyDate,4,2);
                $sDay = substr($sAnyDate,6,2);
                $sUserDate = "$sDay$cSep$sMonth$cSep$sYear";
            }
            else
                $sUserDate = $sAnyDate;
        }
        return $sUserDate;
    }
    
    public function get_html()
    {  
        //$this->isIpadIphone = 1;
        $sHtmlToReturn ="";               
        if($this->_isReadOnly || $this->isIpadIphone) $this->_type = "text"; 
        if($this->oLabel) $sHtmlToReturn .= $this->oLabel->get_html();
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= "<input";
        if($this->_type) $sHtmlToReturn .= " type=\"$this->_type\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        if($this->_name) $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name\"";
        if($this->_convert_date_before_show) $this->_value = $this->to_user_date($this->_value);        
        if($this->_value) $sHtmlToReturn .= " value=\"{$this->get_cleaned($this->_value)}\"";
        //propiedades html5
        if($this->_maxlength)$sHtmlToReturn .= " maxlength=\"$this->_maxlength\"";
        if($this->_isDisabled) $sHtmlToReturn .= " disabled";
        if($this->_isReadOnly) $sHtmlToReturn .= " readonly"; 
        if($this->_isRequired) $sHtmlToReturn .= " required"; 
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
        
        //atributos extras 18/04/2014 este atributo lo dejo siempre para cualquier terminal
        if(!$this->_isReadOnly) $sHtmlToReturn .= " as=\"date\"";
            
        if($this->_placeholder) $sHtmlToReturn .= " placeholder=\"$this->_placeholder\"";
        if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        //if($this->_inFieldsetDiv) $sHtmlDate = $sHtmlFieldSet.$sHtmlDate.$sHtmlFieldSetEnd;
        
        //no funciona de este modo data-options=\"'useClearButton':true}\" con comillas simples encerrrando
        //a useClearButton
        if($this->_type=="date" && $this->_useClearButton)
        {    $sHtmlToReturn .= " data-options='{\"useClearButton\":true}'"; }
        elseif($this->_type=="date" && !$this->_useClearButton) 
        {    $sHtmlToReturn .= " data-options='{\"useClearButton\":false}'"; }
        $sHtmlToReturn .= ">";
        return $sHtmlToReturn;
    }

    //**********************************
    //             SETS
    //**********************************
    public function set_name($value){$this->_name = $value;}
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    public function set_today(){$this->_convert_date_before_show = false;$this->_value = date("d/m/Y");}
    public function in_fieldsetdiv($isOn=true){$this->_inFieldsetDiv = $isOn;}
    public function use_clearbutton($isOn=true){$this->_useClearButton = $isOn;}
    public function set_is_ipadiphone($isOn=true){$this->isIpadIphone = $isOn;}
    public function set_separator($sValue){$this->cSeparator = $sValue;}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    public function readonly($isReadOnly = true){$this->_isReadOnly = $isReadOnly;}
     
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
   
}

/*
<fieldset data-role="controlgroup" data-type="horizontal">
<label for="det_DateP" class="clsRequired" >Fecha</label>    
<input type="date" data-role="datebox" name="det_DateP" id="det_DateP" 
value="<? echo (!$isNew) ? to_user_date($oActivity->get_datep()) : $oSite->get_today_date(); ?>" 
required <?echo (!$isNew)? "readonly":""; ?> class="clsRequired" />
</fieldset>
*/