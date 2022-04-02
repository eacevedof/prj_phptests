<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name HelperInputFile
 * @date 20-04-2014 20:21 (SPAIN)
 * @file helper_input_file.php
 * @observations
 * @requires:
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperInputFile extends TheFrameworkHelper
{
    protected $_maxsize;
    protected $_accept;
  //<input accept="audio/*|video/*|image/*|MIME_type"> 
    public function __construct
    ($id="", $name="", $class="", HelperLabel $oLabel=null)
    {
        $this->oLabel = $oLabel;
        $this->_idprefix = "";
        $this->_type = "file";
        $this->_id = $id;
        $this->_name = $name;
        if($class) $this->arClasses[] = $class;
        $this->oLabel = $oLabel;
    }
    
    public function get_html()
    {  
        $sHtmlToReturn = "";
        
        if($this->oLabel) $sHtmlToReturn .= $this->oLabel->get_html();
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= "<input";
        if($this->_type) $sHtmlToReturn .= " type=\"$this->_type\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        if($this->_name) $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name\"";
        if($this->_value || $this->_value=="0") $sHtmlToReturn .= " value=\"$this->_value\"";
        //bug($this->_value,"input_file $this->_id");
        //propiedades html5
        if($this->_accept) $sHtmlToReturn .= " accept=\"$this->_accept\"";
        if($this->_maxsize) $sHtmlToReturn .= " maxsize=\"$this->_maxsize\"";
        if($this->_isDisabled) $sHtmlToReturn .= " disabled";
        if($this->_isReadOnly) $sHtmlToReturn .= " readonly"; 
        if($this->_isRequired) $sHtmlToReturn .= " required"; 
        //bug($this->_isRequired,  $this->_id);
        //eventos
        if($this->_js_onblur) $sHtmlToReturn .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlToReturn .= " onchange=\"$this->_js_onchange\"";
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
        if($this->_placeholder) $sHtmlToReturn .= " placeholder=\"$this->_placeholder\"";
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        
        $sHtmlToReturn .= ">\n";
        return $sHtmlToReturn;
    }

    //**********************************
    //             SETS
    //**********************************
    public function set_name($value){$this->_name = $value;}
    public function set_value($value,$sVoid=NULL){$this->_value = $value;}
    public function set_maxsize($iNumBytes){$this->_maxsize = $iNumBytes;}
    public function readonly($isReadOnly=true){$this->_isReadOnly=$isReadOnly;}
    public function disabled($isDisabled=true){$this->_isDisabled=$isDisabled;}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    public function set_accept($sAccept){$this->_accept=$sAccept;}
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    public function get_maxsize(){return $this->_maxsize;}
    public function is_readonly(){return $this->_isReadOnly;}
    public function get_accept(){return $this->_accept;}
}