<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name HelperTableTd
 * @date 11-04-2013 14:12
 * @file helper_table_td.php
 * @requires
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperTableTd extends TheFrameworkHelper
{
    private $_colspan = null;
    private $_isHeader = false;
    private $_attr_rownumber;
    private $_attr_colnumber;
    private $_attr_position;
    
    public function __construct($innerhtml="", $id="", $class="", $style="", $colspan="", $arExtras=array())
    {
        $this->_type = "td";
        $this->_idprefix = "td";
        $this->_id = $id;
        
        $this->_inner_html = $innerhtml;
        $this->_colspan = $colspan;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }

    public function get_html()
    {  
        $sHtmlToReturn = "";
        $sHtmlToReturn .= $this->get_opentag();
        //TODO puede que haya conflictos entre el add_inner_object y set_innerobject
        //Hacer pruebas
        $this->load_inner_objects();
        //Tengo que poner "" porque si el valor es mostrar un 0 o un espacio no lo mostraría
        if($this->_inner_html!=="") $sHtmlToReturn .= $this->_inner_html;
        $sHtmlToReturn .= $this->get_closetag();
        return $sHtmlToReturn;
    }
        
    //**********************************
    //             SETS
    //**********************************
    public function set_attr_rownumber($value){$this->_attr_rownumber = $value;}
    public function set_attr_colnumber($value){$this->_attr_colnumber = $value;}
    public function set_colspan($value){$this->_colspan = $value;}
    public function set_as_header($isOn=true){$this->_isHeader=$isOn;
    if($this->_isHeader)$this->_type="th"; else $this->_type="td";}

    public function set_innerobject($mxHtmlObject)
    {
        //si es un array de objetos
        if(is_array($mxHtmlObject))
            foreach($mxHtmlObject as $oHtml)
            {
                if(method_exists($oHtml,"get_html"))
                    $this->_inner_html .= $oHtml->get_html();
            }
        //si es un objeto
        elseif(method_exists($mxHtmlObject,"get_html")) 
            $this->_inner_html .= $mxHtmlObject->get_html();
        else
            $this->_inner_html .= $mxHtmlObject;
    }
    
    public function set_attr_position($iNumRow,$iNumColumn){$this->_attr_position=$iNumRow."_".$iNumColumn;}
    //**********************************
    //             GETS
    //**********************************
    public function get_opentag() 
    {
        $sHtmlToReturn = "<$this->_type";
        if($this->_id) $sHtmlToReturn .= " id=\"$this->_idprefix$this->_id\"";
        if($this->_colspan) $sHtmlToReturn .= " colspan=\"$this->_colspan\"";
        //eventos
        if($this->_js_onblur) $sHtmlToReturn .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlToReturn .= " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $sHtmlToReturn .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $sHtmlToReturn .= " onkeypress=\"$this->_js_onkeypress\"";
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
        if($this->_attr_colnumber!=="") $sHtmlToReturn .= " colnumber=\"$this->_attr_colnumber\"";
        if($this->_attr_rownumber!=="") $sHtmlToReturn .= " rownumber=\"$this->_attr_rownumber\"";
        if($this->_attr_position) $sHtmlToReturn .= " cellpos=\"$this->_attr_position\"";        
        if($this->arExtras) $sHtmlToReturn .= " ".$this->get_extras();

        $sHtmlToReturn .=">";
        return $sHtmlToReturn;
    }
    public function get_closetag(){return parent::get_closetag();}
    public function get_colspan(){return $this->_colspan;}
    public function is_header(){return $this->_isHeader;}
}