<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name Helper Hidden
 * @date 21-11-2016 08:58 (SPAIN)
 * @file helper_input_hidden.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperInputHidden extends TheFrameworkHelper
{
    //private $_name = "hid_name";

    public function __construct($id="",$name="",$value="",$arExtras=array())
    {
        $this->_type = "hidden";
        $this->_idprefix = "";
        $this->_id = $id;
        $this->_value = $value;
        $this->_name = $name;
        $this->arExtras = $arExtras;
    }

    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= "<input";
        if($this->_type) $sHtmlToReturn .= " type=\"$this->_type\"";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        if($this->_name) $sHtmlToReturn .= " name=\"$this->_idprefix$this->_name\"";
        if($this->_value || $this->_value=="0") 
            $sHtmlToReturn .= " value=\"{$this->get_cleaned($this->_value)}\"";
        //propiedades html5
        if($this->_maxlength)$sHtmlToReturn .= " maxlength=\"$this->_maxlength\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $sHtmlToReturn .= " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $sHtmlToReturn .= " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $sHtmlToReturn .= " pk=\"pk\"";
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();
        
        $sHtmlToReturn .= ">\n";
        return $sHtmlToReturn;
    }
    
    //**********************************
    //             TO HIDE
    //**********************************
    //private function get_closetag(){;}     
    //private function get_opentag(){;}

    //**********************************
    //             SETS
    //**********************************
    public function set_name($value){$this->_name = $value;}
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->_name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
}//HelperInputHidden