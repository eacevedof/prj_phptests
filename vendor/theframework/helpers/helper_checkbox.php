<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.3.0
 * @name HelperCheckbox
 * @file helper_checkbox.php
 * @date 03-05-2017 11:55 (SPAIN)
 * @observations:
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperLegend;
use TheFramework\Helpers\HelperFieldset;

class HelperCheckbox extends TheFrameworkHelper
{
    private $arOptions;
    private $arValuesToCheck;
    private $arValuesDisabled;    
    private $isGrouped;
    //private $sOutText;
    private $iChecksPerLine=6;

    private $oLegend;
    private $oFieldset;
    private $isLabeled;
    
    /**
     * 
     * @param mixed $mxOptions array|string Las opciones deben ser array(value=>texto mostrar) si es string solo admite "value" ej. "val1|val2|..|valn"
     * @param string $name 
     * @param mixed $mxValuesToCheck array|string
     * @param mixed $mxValuesDisabled  array|string
     * @param string $class
     * @param array $arExtras
     * @param type $isGrouped
     * @param HelperLegend $oLegend
     * @param HelperFieldset $oFieldset
     */
    public function __construct($mxOptions=array(), $name="", 
            $mxValuesToCheck=array(), $mxValuesDisabled=array(), $class="", $arExtras="",$isGrouped=true,
            HelperLegend $oLegend=null, HelperFieldset $oFieldset=null )
    {
        $this->conv_string_to_array($mxOptions,1);
        $this->conv_string_to_array($mxValuesToCheck);
        $this->conv_string_to_array($mxValuesDisabled);
        
        $this->_type = "checkbox";
        $this->_idprefix = "";
        $this->_name = $name;
        $this->_id = $name;
        $this->isLabeled = FALSE;//permite customizar por defecto la etiqueta
        $this->arOptions = $mxOptions;
        $this->arValuesToCheck = $mxValuesToCheck;
        $this->arValuesDisabled = $mxValuesDisabled;
        $this->isGrouped = $isGrouped;
        if($class) $this->arClasses[] = $class;
        $this->arExtras = $arExtras;
        $this->oLegend = $oLegend;
        $this->oFieldset = $oFieldset;
    }//__construct

    public function get_html()
    {  
        $sHtmlToReturn ="";
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";

        if($this->oFieldset) $sHtmlToReturn .= $this->oFieldset->get_opentag();
        if($this->oLegend) $sHtmlToReturn .= $this->oLegend->get_html();
        
        $iOption=0;
        $iNumOptions = count($this->arOptions);
        foreach($this->arOptions as $sValue=>$sOutText)
        {
            $isChecked = in_array($sValue,$this->arValuesToCheck);
            $isReadOnly = in_array($sValue,$this->arValuesDisabled);
            if($this->_id) $sCheckId = "$this->_idprefix$this->_id";
            if($iNumOptions>1) $sCheckId.="_$iOption";
            //bug($sCheckId);
            //calculo de checkboxes por linea. Si cumple se hace un salto
            if(($iOption%($this->iChecksPerLine))==0 && $iOption>0) $sHtmlToReturn .= "<br/>";
            $sHtmlToReturn .= $this->build_check($sCheckId,$sValue,$sOutText,$isChecked,$isReadOnly);
            //bug($sHtmlToReturn); die;
            $iOption++;            
        }//foreach($this->arOptions)

        if($this->oFieldset) $sHtmlToReturn .= $this->oFieldset->get_closetag();
        //if($this->oLegend) $sHtmlToReturn .= $this->oLegend->get_closetag();
        return $sHtmlToReturn;
    }//get_html

    private function build_check($id, $sValue, $sOutText, $isChecked=false, $isReadOnly=false)
    {
        //$this->sOutText = $sOutText;
        $sHtmlCheckbox ="";
        //if($this->isLabeled) $sHtmlCheckbox .= "<div>";
        $sHtmlCheckbox .= "<input";
        $sHtmlCheckbox .= " type=\"$this->_type\" ";

        if($id) $sHtmlCheckbox .= " id=\"$id\"";
        $sHtmlCheckbox .= " name=\"$this->_idprefix$this->_name";
        if($this->isGrouped) $sHtmlCheckbox .= "[]";
        $sHtmlCheckbox .= "\"";
        $sHtmlCheckbox .= " value=\"$sValue\"";
        
        //eventos
        if($this->_js_onblur) $sHtmlCheckbox .= " onblur=\"$this->_js_onblur\"";

        if($this->_js_onchange && $this->_isPostback) 
            $sHtmlCheckbox .= " onchange=\"$this->_js_onchange;postback(this);\"";
        elseif($this->_js_onchange)$sHtmlCheckbox .= " onchange=\"$this->_js_onchange\"";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isPostback) $sHtmlCheckbox .= " onchange=\"postback(this);\"";

        if($this->_js_onclick) $sHtmlCheckbox .= " onclick=\"$this->_js_onclick\"";
        //if($this->_js_onkeypress) $sHtmlCheckbox .= " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onkeypress && $this->_isEnterInsert) 
            $sHtmlCheckbox .= " onkeypress=\"$this->_js_onkeypress;onenter_insert(event);\"";
        elseif($this->_js_onkeypress && $this->_isEnterUpdate)
            $sHtmlCheckbox .= " onkeypress=\"$this->_js_onkeypress;onenter_update(event);\"";
        elseif($this->_js_onkeypress && $this->_isEnterSubmit)
            $sHtmlCheckbox .= " onkeypress=\"$this->_js_onkeypress;onenter_submit(event);\"";        
        elseif($this->_js_onkeypress)$sHtmlCheckbox .= " onkeypress=\"$this->_js_onkeypress\"";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isEnterInsert) $sHtmlCheckbox .= " onkeypress=\"onenter_insert(event);\"";
        elseif($this->_isEnterUpdate) $sHtmlCheckbox .= " onkeypress=\"onenter_update(event);\"";
        elseif($this->_isEnterSubmit) $sHtmlCheckbox .= " onkeypress=\"onenter_submit(event);\"";
                        
        if($this->_js_onfocus) $sHtmlCheckbox .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlCheckbox .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlCheckbox .= " onmouseout=\"$this->_js_onmouseout\"";
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlCheckbox .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlCheckbox .= " style=\"$this->_style\"";
        //atributos extras
        if($this->_attr_dbfield) $sHtmlCheckbox .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlCheckbox .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->arExtras) $sHtmlCheckbox .= " ".$this->get_extras();
        
        if($isChecked) $sHtmlCheckbox .= " checked";
        if($isReadOnly) $sHtmlCheckbox .= " disabled";
        $sHtmlCheckbox .= ">";
        //out text
        if($this->isLabeled)
        {
            $oLabel = new HelperLabel($id,$sOutText);
            $sHtmlCheckbox .= $oLabel->get_html();
            //$sHtmlCheckbox .= "</div>";
        }
        elseif($sOutText)
            $sHtmlCheckbox .= "$sOutText";
        return $sHtmlCheckbox;
    }//build_check

    private function conv_string_to_array(&$mxStrArray,$isValIndex=0)
    {
        if(!$mxStrArray)
            $mxStrArray = [];
        
        if(is_string($mxStrArray))
        {   
            $mxStrArray = explode("|",$mxStrArray);
            //val index se utiliza para las opciones ya que estas deben
            //ser index1->texto1,index2->texto2
            if($isValIndex)
            {
                $arIndex = array();
                foreach($mxStrArray as $v)
                    $arIndex[$v]="";
                $mxStrArray = $arIndex;
            }
        }//is string
    }//conv_string_to_array

    //**********************************
    //             SETS
    //**********************************
    public function set_fieldset(HelperFieldset $oFieldset){$this->oFieldset = $oFieldset;}
    public function set_legend(HelperLegend $oLegend){$this->oLegend = $oLegend;}
    //public function set_value($value){$this->conv_string_to_array($value);$this->arValuesToCheck = $value;}
    public function set_values_to_check($mxValues){$this->conv_string_to_array($mxValues);$this->arValuesToCheck = $mxValues;}
    public function not_grouped_name($isOn=false){$this->isGrouped = $isOn;}
    public function set_checks_per_line($iNumChecks){$this->iChecksPerLine = $iNumChecks;}
    public function set_options($mxOptions){$this->conv_string_to_array($mxOptions,1);$this->arOptions=$mxOptions;}
    public function set_unlabeled($isOn=TRUE){$this->isLabeled=!$isOn;}
    public function set_name($value){$this->_name=$value;}
    
    //**********************************
    //             GETS
    //**********************************    
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    //public function show_opentag(){parent::show_opentag();}
    //public function show_closetag(){parent::show_closetag();}    
}//HelperCheckbox