<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.0
 * @name HelperSelect
 * @date 17-02-2016 17:27
 * @file helper_select.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperSelect extends TheFrameworkHelper
{
    private $arOptions;
    private $mxValuesToSelect=null;
    private $_selected_as_hidden=null;
    private $_isMultiple;
    private $_size;
    
    public function __construct
    ($arOptions, $id="", $name="", HelperLabel $oLabel=null, $mxValueToSelect ="", $size=1
     , $isMultiple=FALSE, $arExtras="", $class="", $isReadOnly=FALSE)
    {
        $this->_type = "select";
        $this->mxValuesToSelect = $mxValueToSelect;
        
        $this->arOptions = $arOptions;
        $this->_idprefix = "";
        $this->_id = $id;
        $this->_name = $name;
        $this->_isMultiple = $isMultiple;
        if($this->_size>1) $this->_isMultiple = true;
        $this->_size = $size;
        $this->oLabel = $oLabel;
        $this->arExtras = $arExtras;
        if($class) $this->arClasses[] = $class;
        $this->_isReadOnly = $isReadOnly;
    }

    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->oLabel) $sHtmlToReturn .= $this->oLabel->get_html();
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag(); 
        //INICIO OPTIONS
        if(!is_array($this->mxValuesToSelect)) 
            $mxValueToSelect = (string)$this->mxValuesToSelect;
        else 
            $mxValueToSelect = $this->mxValuesToSelect;
        
        //No es readonly
        if(!$this->_isReadOnly)        
        {
            if(!$this->_isMultiple)
            {    
                //bug($mxValueToSelect,"to sel of $this->_id");
                foreach($this->arOptions as $sValue=>$sInnerText)
                {
                    $sOptionValue = (string)$sValue;
                    //bug("$mxValueToSelect===$sOptionValue");
                    $isSelected = ($mxValueToSelect===$sOptionValue);
                    $sHtmlToReturn .= $this->build_htmloption($sValue, $sInnerText, $isSelected);
                }
            }
            //Multiple
            else
            {
                foreach($this->arOptions as $sValue=>$sInnerText)
                {
                    if(is_array($mxValueToSelect))
                        $isSelected = in_array($sValue, $mxValueToSelect);
                    else
                        $isSelected = ($mxValueToSelect==((string)$sValue));
                    $sHtmlToReturn .= $this->build_htmloption($sValue, $sInnerText, $isSelected);
                }
            }
        }
        //es readonly
        else
        {
            if(!$this->_isMultiple)
            {
                //Hay dos opciones y una es vacia.
                if(count($this->arOptions)<=2 && key_exists("", $this->arOptions))
                {
                    unset($this->arOptions[""]);
                    $arItemReadonly = $this->arOptions;
                }
                //no tiene item en blanco
                else
                {    
                    //recupera el valor de autoselección
                    $arItemReadonly = $this->get_item_readonly($this->arOptions,$mxValueToSelect);
                }
                foreach($arItemReadonly as $sValue => $sText)
                    $sHtmlToReturn .= $this->build_htmloption($sValue, $sText, true);
            }
            //es readonly y multiple
            else
            {
                //bug("is multiple"); bug(is_array($this->_isMultiple),"is multiple");
                //Falta implementar
            }
        }//fin es readonly
        //FIN OPTIONS
        
        $sHtmlToReturn .= $this->get_closetag();
        $sHtmlToReturn .= $this->_selected_as_hidden;
        return $sHtmlToReturn;
    }
        
    public function get_opentag()
    {
        $sHtmlToReturn = "<$this->_type";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        //Nombre dependiendo si es multiple o no
        if($this->_isMultiple) $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name[]\"";
        else $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name\"";
        
        if($this->_size) $sHtmlToReturn .= " size=\"$this->_size\"";
        if($this->_isMultiple) $sHtmlToReturn .= " multiple";
        if($this->_isDisabled) $sHtmlToReturn .= " disabled";
        //if($this->_isReadOnly) $sHtmlToReturn .= " readonly"; no existe esta propiedad para select
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
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        $sHtmlToReturn .= ">\n";
        return $sHtmlToReturn;        
    }    
   
    /**
     * @param array $arOptions
     * @param string $sValueToSelect
     * @return array De un solo item tipo array[$value]=innertext
     */
    private function get_item_readonly($arOptions,$sValueToSelect)
    {
        $arItemReadOnly = array(""=>"");
        foreach($arOptions as $sOptValue=>$sOptText)
            if($sValueToSelect == (string)$sOptValue)
            {    
                $arItemReadOnly = array($sOptValue=>$sOptText);
                return $arItemReadOnly;
            }
        return $arItemReadOnly;
    }
   
    /**
     * @param array $arOptions 
     * @param array $arValuesToSelect
     * @return array
     */
    private function get_items_readonly($arOptions,$arValuesToSelect=array())
    {
        $arItemReadOnly = array();
        
        foreach($arOptions as $sOptValue=>$sOptText)
            foreach($arValuesToSelect as $sValue)
                if($sValue == (string)$sOptValue)
                    $arItemReadOnly[$sOptValue] = $sOptText;
        
        if(empty($arItemReadOnly))$arItemReadOnly = array(""=>"");
        
        return $arItemReadOnly;
    }
    
    private function build_htmloption($value,$innertext,$isSelected=FALSE)
    {
        $sOption = "";
        $sOption .= "\t<option";
        $sOption .= " value=\"$value\"";
        if($isSelected) $sOption .= " selected";
        $sOption .= ">";
        $sOption .= htmlentities($innertext);                  
        $sOption .= "</option>\n";
        return $sOption;
    }

    //**********************************
    //             SETS
    //**********************************
    //protected function set_value(){;}
    
    public function readonly($isReadOnly=true){$this->_isReadOnly = $isReadOnly;}
    public function set_name($value){$this->_name = $value;}
    public function set_value_to_select($mxValues){$this->mxValuesToSelect = $mxValues;}
    public function set_null_option_text($value){$this->_null_option = $value;}
    public function set_multiple_size($value)
    {
        $this->_size = (int)$value;
        if($this->_size>1) $this->_isMultiple = true;
    }
    
    /**
     * Usar en caso de aplicar el atributo disabled: set_extras("disabled");
     */
    public function set_selected_value_as_hidden_on()
    {
        $this->_selected_as_hidden = "
        <input type=\"hidden\" name=\"$this->_name\" id=\"$this->_id\" value=\"$this->mxValuesToSelect\"/>\n";
    }
    
    public function set_options($arOptions){$this->arOptions=$arOptions;}    
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    //public function get_value(){return $this->_value;}
    public function get_selected_value(){return $this->mxValuesToSelect;}
    public function get_closetag(){return parent::get_closetag();}
}