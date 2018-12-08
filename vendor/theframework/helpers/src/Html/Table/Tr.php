<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.2
 * @name TheFramework\Helpers\Html\Table\TableTr
 * @date 25-06-2014 09:25 ESP
 * @file TableTr.php
 * @requires
 */
namespace TheFramework\Helpers\Html\Table;
use TheFramework\Helpers\TheFrameworkHelper;
class TableTr extends TheFrameworkHelper
{
    protected $isRowHead = false;
    protected $isRowFoot = false;
    protected $iColSpan = null;
    protected $iRowSpan = null;
    protected $iNumCols = 0;
    
    protected $sAttrRownumber;
    
    public function __construct
    ($arInnerObjectss=array(), $id="", $class="", $style="", $colspan=""
            , $rowpan="", $arExtras=array())
    {
        $this->_type = "tr";
        $this->_inner_html = "";
        $this->_idprefix = "tr";
        $this->_id = $id;
        
        //$this->_inner_html = $innertext;
        $this->arInnerObjects = $arInnerObjectss;
        $this->iNumCols = count($this->arInnerObjects);
        $this->iColSpan = $colspan;
        $this->iRowSpan = $rowpan;
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }

    public function get_html()
    {
        $sHtmlToReturn = $this->get_opentag();
        //$this->_inner_html .= $this->get_tds_as_string();
        $this->load_inner_objects();
        if($this->_inner_html) $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }
    
    public function get_opentag() 
    {
         //tr
        $sHtmlToReturn = "<$this->_type";
        if($this->_id) $arHtml[] = " id=\"$this->_idprefix$this->_id\"";
        if($this->iRowSpan) $arHtml[] = " rowspan=\"$this->iRowSpan\"";
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arHtml[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arHtml[] = " style=\"$this->_style\"";
        //atributos extras
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";  
        if($this->sAttrRownumber!=="") $arHtml[] = " rownumber=\"$this->sAttrRownumber\"";  
        $sHtmlToReturn .=">\n";
        return implode("",$arHtml);
    }
    
    public function get_closetag(){ return parent::get_closetag();}
        
    //==================================
    //             SETS
    //==================================
    public function set_colspan($value){$this->iColSpan = $value;}
    public function set_objtds($arInnerObjects=array()){$this->arInnerObjects = $arInnerObjects;$this->iNumCols = count($this->arInnerObjects);}
    public function set_as_rowhead($isOn=TRUE){$this->isRowHead = $isOn;}
    public function set_as_rowfoot($isOn=TRUE){$this->isRowFoot = $isOn;}
    public function set_attr_rownumber($value){$this->sAttrRownumber = $value;}
    public function add_inner_object($mxValue){$this->arInnerObjects[] = $mxValue; $this->iNumCols = count($this->arInnerObjects);}
    public function add_td(HelperTr $oTd){$this->arInnerObjects[] = $oTd; $this->iNumCols = count($this->arInnerObjects);}

    //==================================
    //             GETS
    //==================================
    public function get_colspan(){return $this->iColSpan;}
    public function get_objtds(){return $this->arInnerObjects;}
    public function is_rowhead(){return $this->isRowHead;}
    public function is_rowfoot(){return $this->isRowFoot;}
    public function get_num_columns(){return $this->iNumCols;}
    
}//TableTr