<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.2.2
 * @name TheFrameworkHelper
 * @file theframework_helper.php
 * @date 30-07-2016 16:12 (SPAIN)
 *  load:22
 * @observations:
 */
namespace TheFramework\Helpers;

class TheFrameworkHelper 
{
    protected $_comments = "";
    protected $_type = "";
    protected $_id = "";
    protected $_name = "";
    protected $_idprefix = "";
    protected $_maxlength = "";
    
    protected $_inner_html = ""; 
    protected $arExtras;
    protected $_placeholder;
    
    protected $_display = TRUE;
    protected $_class = "";
    protected $_style = "";
    protected $arClasses = array();
    protected $arStyles = array();
    protected $arInnerObjects = array();
    protected $_value;

    //Esto emula el atributo bloqueado. Si esta a TRUE crea el control autoseleccionado con un
    //único valor en los objetos tipo select
    protected $_is_primarykey = FALSE;
    protected $_isReadOnly = FALSE;
    protected $_isRequired = FALSE;
    protected $_isDisabled = FALSE;
    protected $_isPrimaryKey = FALSE;
    protected $_isPostback = FALSE;
    protected $_isEnterInsert = FALSE;//aplica action=insert
    protected $_isEnterUpdate = FALSE;//aplica action=update
    protected $_isEnterSubmit = FALSE;//no aplica nada
    
    protected $_js_onclick = NULL;
    protected $_js_onchange = NULL;
    protected $_js_onkeypress = NULL;
    protected $_js_onkeydown = NULL;
    protected $_js_onkeyup = NULL;
    
    protected $_js_onblur = NULL;
    protected $_js_onfocus = NULL;
    protected $_js_onmouseover = NULL;
    protected $_js_onmouseout = NULL;    
    
    protected $_attr_dbtype = NULL;
    protected $_attr_dbfield = NULL;
    
    protected $oBD = NULL;
    //HelperLabel
    protected $oLabel = NULL;
    //HelperStyle
    protected $oStyle = NULL;
    
    public function __construct(){}
    
    /**
     * Remplaza el atributo _class con las clases añadidas a arClasses
     */
    protected function load_cssclass(){if($this->arClasses)$this->_class = trim(implode(" ",$this->arClasses));}
    /**
     * Remplaza el atributo _style con los estilos en arStyles
    */
    protected function load_style(){if($this->arStyles)$this->_style = trim(implode(";",$this->arStyles));}
    /**
     * Agrega al atributo _inner_html el string obtenido con el metodo get_html()
     */
    protected function load_inner_objects()
    {
        foreach($this->arInnerObjects as $mxValue)
            if(is_object($mxValue) && method_exists($mxValue,"get_html"))
                $this->_inner_html .= $mxValue->get_html();
            elseif(is_string($mxValue))
                $this->_inner_html .= $mxValue;
//            elseif(is_array($mxValue))
//                die;
    }
    
    protected function concat_param_value($sParamName,$sValue)
    {
        $sValue = urlencode($sValue);
        return "$sParamName=$sValue";
    }  
    
    protected function build_uri_params_with_keys($arKeysAndValues=array())
    {
        $arDestinyKeys = array();
        $sDestinyKeys = "";
        foreach($arKeysAndValues as $sFieldName=>$value)
            $arDestinyKeys[]=$this->concat_param_value($sFieldName, $value);

        if(!empty($arDestinyKeys))
            $sDestinyKeys = implode("&",$arDestinyKeys);
        return $sDestinyKeys;
    }
    
    protected function extract_fields_and_values($arFields, $arFieldNames)
    {
        $arExtracted = array();
        foreach($arFields as $sFieldName=>$value)
            if(in_array($sFieldName, $arFieldNames))
                $arExtracted[$sFieldName] = $value;
        return $arExtracted;
    }
       
    /**
     * De un array tipo ("fieldname"=>"value") recupera solo los "value" de los "fieldname"
     * indicados en $arFieldNames
     * @param array $arFields
     * @param array $arFieldNames
     * @param boolean $asArray
     * @param string $sSeparator
     * @return mixed Array or String depende de $asArray
     */
    protected function extract_values($arFields, $arFieldNames, $asArray=FALSE, $sSeparator="-")
    {
        $arExtracted = array(); $sExtracted="";
        foreach($arFields as $sFieldName=>$value)
            if(in_array($sFieldName, $arFieldNames)) 
                $arExtracted[] = $value;

        if(!empty($arExtracted) && !$asArray)
            $sExtracted = implode($sSeparator,$arExtracted);
        elseif(empty($arExtracted) && !$asArray)
            $sExtracted = "";
        else
            $sExtracted = $arExtracted;
        return $sExtracted;
    }  
    
    public function show(){if($this->_display) echo $this->get_html();}
    
    //**********************************
    //             SETS
    //**********************************
    public function set_comments($value){$this->_comments = $value;}
    public function set_idprefix($value){$this->_idprefix=$value;}
    public function set_id($value){$this->_id=$value;}
    public function set_js_onclick($value){$this->_js_onclick = $value;}
    public function set_js_onchange($value){$this->_js_onchange = $value;}
    public function set_js_keypress($value){$this->_js_onkeypress = $value;}
    public function set_js_keydown($value){$this->_js_onkeydown = $value;}
    public function set_js_keyup($value){$this->_js_onkeyup = $value;}
    public function set_js_onblur($value){$this->_js_onblur = $value;}
    public function set_js_onfocus($value){$this->_js_onfocus = $value;}
    public function set_js_onmouseover($value){$this->_js_onmouseover = $value;}
    public function set_js_onmouseout($value){$this->_js_onmouseout = $value;}
    
    public function display($showIt=TRUE){$this->_display = $showIt;}        
    protected function required($isRequired=TRUE){$this->_isRequired = $isRequired;}
    protected function readonly($isReadOnly=TRUE){$this->_isReadOnly = $isReadOnly;}
    protected function disabled($isDisabled=TRUE){$this->_isDisabled = $isDisabled;}
    public function add_class($class){if($class) $this->arClasses[] = $class;}

    public function add_style($style){if($style) $this->arStyles[] = $style;}
    /**
     * 
     * @param mixed $mxValue helper object or string
     */
    public function add_inner_object($mxValue){if($mxValue) $this->arInnerObjects[] = $mxValue;}
    
    public function set_extras(array $value){$this->arExtras = array(); if($value) $this->arExtras = $value;}
    public function add_extras($sKey,$sValue)
    {
        if($sKey)
            $this->arExtras[$sKey] = $sValue;
        else
            $this->arExtras[] = $sValue;
    }
    
    protected function set_placeholder($value){$this->_placeholder = htmlentities($value);}
    public function set_attr_dbtype($value){$this->_attr_dbtype=$value;}
    public function set_attr_dbfield($value){$this->_attr_dbfield=$value;}
    public function set_as_primarykey($isPk=TRUE){$this->_is_primarykey = $isPk;}
    public function set_innerhtml($sInnerHtml,$asEntity=0)
    {if($asEntity)$this->_inner_html = htmlentities($sInnerHtml);else $this->_inner_html=$sInnerHtml;}
    public function set_type($value){$this->_type = $value;}
    public function set_postback($isOn=TRUE){$this->_isPostback=$isOn;}
    public function on_enterinsert($isOn=TRUE){$this->_isEnterInsert=$isOn;}
    public function on_enterupdate($isOn=TRUE){$this->_isEnterUpdate=$isOn;}
    public function on_entersubmit($isOn=TRUE){$this->_isEnterSubmit=$isOn;}
    
    protected function set_name($value){$this->_name = $value;}

    protected function set_label(HelperLabel $oLabel){$this->oLabel = $oLabel;}
    public function set_class($class){$this->arClasses=array();if($class)$this->arClasses[] = $class;}    
    public function set_style($value){$this->arStyles=array();if($value) $this->arStyles[] = $value;}
    protected function set_style_object(HelperStyle $oStyle){$this->oStyle = $oStyle;}
    protected function reset_class(){$this->arClasses=array();$this->_class="";}
    protected function reset_style(){$this->arStyles=array();$this->_style="";}
    protected function reset_inner_object(){$this->arInnerObjects=array();}
    protected function set_inner_objects($arObjHelpers){$this->arInnerObjects=$arObjHelpers;}
    protected function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    protected function get_cleaned($sString)
            {
        $sString = str_replace("\"","&quot;",$sString);
        return $sString;
            }
    
    //**********************************
    //             GETS
    //**********************************
    public function get_id(){return $this->_id;}
    public function get_type(){return $this->_type;}
    public function get_class(){return $this->_class;}
    public function get_extras($asString=TRUE)
    {
        $arExtras = array();
        if($asString)
        {
            foreach($this->arExtras as $sKey=>$sValue)
            {
                //Esto no funcionaría si aplicase valores para mostrar un atributo 0="nuevo"
                if(is_integer($sKey))
                {
                    if(strstr($sValue,"="))
                        $arExtras[] = $sValue;
                    else
                        $arExtras[] = "$sKey=\"$sValue\"";    
                }
                else 
                {
                    $arExtras[] = "$sKey=\"$sValue\"";
                }
            }
            return implode(" ",$arExtras);
        }
        else
            return $this->arExtras;
    }//get_extras
    
    public function get_innerhtml(){return $this->_inner_html;}
    protected function is_disabled(){return $this->_isDisabled;}

    public function get_dbtype(){return $this->_attr_dbtype;}
    public function is_primarykey(){return $this->_is_primarykey;}
    protected function get_name(){return $this->_name;}
    
    protected function get_icon_path($isIcon,$sIconFile)
    {
        $sIconPath = "images/";
        $sIconPath .= $sIconFile;
        if($isIcon && is_file($sIconPath))
            return $sIconPath;
        return "";    
    }
    
    //**********************************
    // OVERRIDE TO PUBLIC IF NECESSARY
    //**********************************
    //to override
    protected function get_opentag(){}
    //to override
    protected function get_closetag(){return "</$this->_type>\n";}
    //to override
    protected function show_opentag(){echo $this->get_opentag();}
    //to override
    protected function show_closetag(){echo $this->get_closetag();}
    protected function get_label(){return $this->oHlpLabel;}
    protected function get_style(){return $this->oHlpStyle;}
    protected function get_placeholder(){return $this->_placeholder;}

    protected function is_enterinsert(){return $this->_isEnterInsert;}
    protected function is_enterupdate(){return $this->_isEnterUpdate;}
    protected function is_entersubmit(){return $this->_isEnterSubmit;}
    protected function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}    
}