<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 2.0.0
 * @name HelperTableRaw
 * @date 14-05-2017 07:19 (SPAIN)
 * @file helper_table_raw.php
 * @requires 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperTableRaw extends TheFrameworkHelper
{
    protected $arLabels;
    protected $arRows;

    public function __construct($arRows,$arLabels=array()) 
    {
        $this->_idprefix = "";
        $this->_type = "table";
        $this->arRows = $arRows;
        $this->arLabels = $arLabels;
    }
    
    public function get_opentag()
    {
        $sHtmlOpenTag = "<$this->_type";
        if($this->_id) $sHtmlOpenTag .= " id=\"$this->_idprefix$this->_id\"";

        //eventos
        if($this->_js_onblur) $sHtmlOpenTag .= " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $sHtmlOpenTag .= " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $sHtmlOpenTag .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress)$sHtmlOpenTag .= " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onclick) $sHtmlOpenTag .= " onclick=\"$this->_js_onclick\"";
        if($this->_js_onfocus) $sHtmlOpenTag .= " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $sHtmlOpenTag .= " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $sHtmlOpenTag .= " onmouseout=\"$this->_js_onmouseout\"";
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlOpenTag .= " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $sHtmlOpenTag .= " style=\"$this->_style\"";            
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();

        $sHtmlOpenTag .=">\n";
        return $sHtmlOpenTag;
    }//get_opentag
    
    public function get_html() 
    {
        $sHtmlToReturn = $this->get_opentag()."\n";
        //si no se hay pasado etiquetas se intentan recuperar desde la primera fila
        if(!$this->arLabels)
            if(is_array($this->arRows[0]))
                $this->arLabels = array_keys($this->arRows[0]);
        
        //LABELS EN COLUMNAS
        if($this->arLabels)
        {
            $sHtmlToReturn .= "<tr>";
            foreach($this->arLabels as $sLabel)
                $sHtmlToReturn .= "<th>$sLabel</th>";
            $sHtmlToReturn .= "</tr>\n";
        }       
        
        //DATOS
        if($this->arRows)
        {
            foreach($this->arRows as $arRows)
            {
                $sHtmlToReturn .= "<tr>";
                foreach($arRows as $sValue)
                    $sHtmlToReturn .= "<td>$sValue</td>";    
                $sHtmlToReturn .= "</tr>\n";
            }
        }

        $sHtmlToReturn .= "</table>";
        return $sHtmlToReturn;
    }//get_html
    
    public function set_data($arRows){$this->arRows = $arRows;}
    public function set_labels($arLabels){$this->arLabels=$arLabels;}
}//HelperTableRaw