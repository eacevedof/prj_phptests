<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 2.0.0
 * @name TheFramework\Helpers\Html\Table\Raw
 * @date 14-05-2017 07:19 (SPAIN)
 * @file Raw.php
 * @requires 
 */
namespace TheFramework\Helpers\Html\Table;
use TheFramework\Helpers\TheFrameworkHelper;

class Raw extends TheFrameworkHelper
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
        $arOpenTag[] = "<$this->_type";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";

        //eventos
        if($this->_js_onblur) $arOpenTag[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arOpenTag[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress)$arOpenTag[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onfocus) $arOpenTag[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arOpenTag[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arOpenTag[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arOpenTag[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arOpenTag[] = " style=\"$this->_style\"";            
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();

        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);
    }//get_opentag
    
    public function get_html() 
    {
        $arHtml[] = $this->get_opentag()."\n";
        //si no se hay pasado etiquetas se intentan recuperar desde la primera fila
        if(!$this->arLabels)
            if(isset($this->arRows[0]) && is_array($this->arRows[0]))
                $this->arLabels = array_keys($this->arRows[0]);
        
        //LABELS EN COLUMNAS
        if($this->arLabels)
        {
            $arHtml[] = "<tr>";
            foreach($this->arLabels as $sLabel)
                $arHtml[] = "<th>$sLabel</th>";
            $arHtml[] = "</tr>\n";
        }       
        
        //DATOS
        if($this->arRows)
        {
            foreach($this->arRows as $arRows)
            {
                $arHtml[] = "<tr>";
                foreach($arRows as $sValue)
                    $arHtml[] = "<td>$sValue</td>";    
                $arHtml[] = "</tr>\n";
            }
        }

        $arHtml[] = "</table>";
        return implode("",$arHtml);
    }//get_html
    
    public function set_data($arRows){$this->arRows = $arRows;}
    public function set_labels($arLabels){$this->arLabels=$arLabels;}
}//TableRaw