<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.10
 * @name TheFramework\Helpers\Html\Table\Table
 * @date 30-07-2016 15:44 (SPAIN)
 * @file Table.php
 * @requires
 *  Table_td.php
 *  ,Table_tr.php
 */
namespace TheFramework\Helpers\Html\Table;
use TheFramework\Helpers\TheFrameworkHelper;
//import_helper("table_td,table_tr");
class Table extends TheFrameworkHelper
{
    protected $arObjTrs = null;
    protected $useThead = false;
    protected $useTfoot = false;    
    protected $iNumRows = 0;
    protected $iNumCols = 0;
    
    public function __construct
    ($arMxTrs=array(), $id="", $class="", $style="", $arExtras=array())
    {
        //clientbrowser,isMobileDevice,consolecalled,permalink
        parent::__construct();
        $this->_type = "table";
        $this->_idprefix = "tbl";
        $this->_id = $id;
        $this->_inner_html = "";
        
        $this->arObjTrs = $arMxTrs;
        $this->iNumRows = count($this->arObjTrs);
        $this->load_numcols();
        
        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }

    protected function load_numcols()
    {
        $this->iNumCols = 0;
        if(isset($this->arObjTrs[0]))
        {
            if(is_object($this->arObjTrs[0]))
                $this->iNumCols = count($this->arObjTrs[0]->get_num_columns());
            elseif(is_array($this->arObjTrs[0]))
                $this->iNumCols = count($this->arObjTrs[0]);
            else
                $this->iNumCols = substr_count($this->arObjTrs[0],"</td>");  
        }
    }
    
    //table
    public function get_html()
    {  
        $arHtml = array();
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag(); 
        //Agrega a inner_html los valores obtenidos con get_html de cada objeto en $this->arInnerObjects
        //No usa inner objects porque lo unico q se puede añadir a un elemento <table> como innerhtml son trs
        //$this->load_inner_objects();
        //$this->get_html_rows(): No es un simple bucle que recorre todos los objetos filas.
        //este metodo recupera las filas th, tfoot y tr y guarda en cada caso los indices correspondientes
        //para que despues se pinten de cabecera a pie. Esto da la versatilidad de añadir tr en cualquier puno del array
        //con su tipo y el metodo se encargará de ordenarlo
        if(!$this->_inner_html) $this->_inner_html = $this->get_html_rows();
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }
        
    public function get_opentag()
    {
        $sHtmlToReturn = "<$this->_type";
        if($this->_id) $arHtml[] = " id=\"$this->_idprefix$this->_id\"";
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
        //if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";  
        $sHtmlToReturn .=">\n";
        return implode("",$arHtml);
    }    
    
    protected function get_html_rows()
    {
        $arPosHead = $this->get_positions_head();
        $arPosFoot = $this->get_positions_foot();
        $arPosBody = $this->get_positions_body($arPosHead,$arPosFoot);
        
        $sHtmlRows = "";
        $sHtmlRows .= $this->build_thead($arPosHead);
        $sHtmlRows .= $this->build_tfoot($arPosFoot);
        $sHtmlRows .= $this->build_tbody($arPosBody);
        
        return $sHtmlRows;
    }
    
    /**
     * En el array de filas (arObjTrs) se puede añadir distintos tipos de datos. 
     * Lo ideal es que sea un objeto ya que el framework se basa en POO.  No obstante
     * se puede añadir strings tipo raw o array de strings tds
     * @param mixed $mxTr Object HelperTr, array <td>..</td>, string <tr>
     * @return string tr as html
     */
    protected function get_mxtr_as_string($mxTr)
    {
        $sTr = "";
        //si es un objeto tipo helper
        if(is_object($mxTr) && method_exists($mxTr,"get_html")) 
            $sTr .= "\t".$mxTr->get_html();
        //array de tds array("<td>...</td>","<td>..</td>",...)
        elseif(is_array($sTr)) 
            $sTr .= "\t<tr>".implode("\n",$mxTr)."</tr>";
        else//string tipo <tr>...</tr>
            $sTr .= "\t".$mxTr;
        return $sTr;
    }
    
    protected function build_thead($arPosHead=array())
    {
        $sTr = "";
        foreach($arPosHead as $iPos)
        {    
            $mxTr = $this->arObjTrs[$iPos];
            $sTr .= $this->get_mxtr_as_string($mxTr);
        }
        $sThead = "";
        if($sTr!="") $sThead = "<thead id=\"tblh\">\n$sTr</thead>\n";
        
        return $sThead;
    }
    
    protected function build_tbody($arPosBody=array())
    {
        $sTr = "";
        foreach($arPosBody as $iPos)
        {    
            $mxTr = $this->arObjTrs[$iPos];
            $sTr .= $this->get_mxtr_as_string($mxTr);
        }
        $sTbody = "";
        if($sTr!="") $sTbody = "<tbody id=\"tblb\">\n$sTr</tbody>\n";
        
        return $sTbody;
    }

    protected function build_tfoot($arPosFoot=array())
    {
        $sTr = "";
        foreach($arPosFoot as $iPos)
        {    
            $mxTr = $this->arObjTrs[$iPos];
            $sTr .= $this->get_mxtr_as_string($mxTr);
        }
        $sTfoot = "";
        if($sTr!="") $sTfoot = "<tfoot id=\"tblf\">\n$sTr</tfoot>\n";
        
        return $sTfoot;
    }

    protected function get_positions_head()
    {
        $arReturn = array();
        if($this->useThead)
            foreach($this->arObjTrs as $i=>$mxRow)
            {   
                if(is_object($mxRow) && $mxRow->is_rowhead())
                    $arReturn[]=$i;
                //array tds
                elseif(is_array($mxRow))
                {   
                    $isHead = false;
                    foreach($mxRow as $sTd)
                        if(is_string($sTd) && strstr($sTd,"</th>"))
                        { 
                            $isHead = true;
                            break;
                        }
                    if($isHead) $arReturn[]=$i;
                }
                //string
                elseif(is_string($mxRow) && strstr($mxRow,"</th>"))
                {
                    $arReturn[]=$i;
                }
                else //Es objeto y no es rowhead
                {
                    //bug($mxRow);
                }
            }//foreach arObjTrs
        return $arReturn;
    }
    
    protected function get_positions_body($arPosHead=array(), $arPosFoot=array())
    {
        $arReturn = array();
        //TODO solo usar indices
        //foreach($this->arObjTrs as $i=>$oTr)
        $iRows = count($this->arObjTrs);
        for($i=0; $i<$iRows; $i++)
            if(!in_array($i,$arPosHead) && !in_array($i,$arPosFoot))
                $arReturn[] = $i;
        
        return $arReturn;
    }
    
    protected function get_positions_foot()
    {
        $arReturn = array();
        if($this->useTfoot)
            foreach($this->arObjTrs as $i=>$oRow)
                //la unica forma de saber si es pie es que sea un objeto sino no
                if(is_object($oRow) && $oRow->is_rowfoot())
                    $arReturn[]=$i;

        return $arReturn;
    }
    //**********************************
    //             SETS
    //**********************************
    public function use_header($isOn=true){$this->useThead=$isOn;}
    public function use_footer($isOn=true){$this->useTfoot=$isOn;}
    public function set_objrows($objArray=array())
    {
        $this->arObjTrs = $objArray;
        $this->iNumRows = count($this->arObjTrs);
        $this->load_numcols();
    }
    
    /**
     * string: "<tr>...</tr>"
     * object: Any object with get_html method
     * array: array(0=>"<td>...</td>",1=>"<td>...</td>"...)
     * @param string|object|array 
     */
    public function add_objrow($mxValue){$this->arObjTrs[] = $mxValue; $this->iNumRows = count($this->arObjTrs); $this->load_numcols();}
    
    public function add_tr(TableTr $oTr){$this->arObjTrs[] = $oTr; $this->iNumRows = count($this->arObjTrs); $this->load_numcols();}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_objrows(){return $this->arObjTrs;}
    
}