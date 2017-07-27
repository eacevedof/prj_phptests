<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name HelperImagelist
 * @file helper_imagelist.php 
 * @date 29-10-2014 09:44 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperImagelist extends TheFrameworkHelper
{
    protected $isRaw;
    protected $sTopTitle;
    protected $sTopText;
    protected $sLiClass;
    protected $arLi;
    protected $iInfoCurrentPage;
    protected $iInfoFirstPage;
    protected $iInfoPreviousPage;
    protected $iInfoNumRegs;
    protected $iInfoLastPage;
    protected $iInfoNumPages;
    protected $iItempsPerPage;
    protected $arObjFields;
    protected $sUrlPaginate;
    protected $sOrderBy;
    protected $sOrderType;
    
    /**
     * 
     * @param array $arLi $arLinks[] = array("src"=>$sUrlBase."logo_unioncaribe_496_133.jpg","href"=>$this->build_url("modulebuilder"),"innerhtml"=>"3","alt"=>"ok3","text"=>array("text","link"));
     * @param string $id
     */
    public function __construct($arLi=array(),$id=NULL)
    {
        $this->_id = $id;
        $this->arClasses[] = "thumbnails";
        if($this->isRaw) $this->arClasses[] = "raw";
        $this->arLi = $arLi;
        $this->sLiClass = "span2";
        $this->load_url_paginate();
    }
    
    protected function get_fields_as_string()
    {
        $sHtmlString = "";
        foreach($this->arObjFields as $arObjField)
            $sHtmlString .= $arObjField->get_html();
        return $sHtmlString;
    }
    
    public function get_html()
    {
        $sHtmlToReturn = "";
        $oFieldset = new HelperFieldset();        
        $oForm = new HelperForm("frmList");
        $oForm->add_class("form-horizontal");
        $oForm->add_style("margin:0;padding:0;border:0;");
  
        $sHtmlToReturn .= $oForm->get_opentag();
        $sHtmlToReturn .= $oFieldset->get_opentag();
        //Los campos que se mostrarán antes del listado. Suele ser para filtrs
        $sHtmlToReturn .= $this->get_fields_as_string();
        $sHtmlToReturn .= $oFieldset->get_closetag();
        //Barra de navegacion por paginas
        $sHtmlToReturn .= $this->get_paginate_info();
        $sHtmlToReturn .= $this->build_hidden_fields();
        $sHtmlToReturn .= $oForm->get_closetag();

        if(!empty($this->arLi))
        {
            $oUl = new HelperUl($this->_id);
            foreach($this->arClasses as $class)
                $oUl->add_class($class);
            
            $arLiObjects = array();
            foreach($this->arLi as $arLi)
            {
                $oLi = new HelperUlLi();
                $oAnchor = new HelperAnchor();
                $oImage = new HelperImage();
                
                $sHref = $arLi["href"];
                $sAlt = $arLi["alt"];
                $sImageUrl = $arLi["src"];
                $sTarget = $arLi["target"];
                $mxText = $arLi["text"];
                
                $oImage->set_src($sImageUrl);
                $oImage->set_alt($sAlt);
                $oImage->set_title($sAlt);
                
                $oAnchor->set_href($sHref);
                $oAnchor->add_class("thumbnail");

                $oAnchor->add_inner_object($oImage);
                $oAnchor->set_target($sTarget);
                $oLi->add_inner_object($oAnchor);
                
                if($mxText)
                {
                    //No link <span></span>
                    if(is_string($mxText))
                    {   
                        $oMxText = new HelperSpan();
                        $oMxText->set_innerhtml($mxText);
                        //$oMxText->add_style("font-weight:bold;");
                        $oMxText->add_class("label");
                    }
                    //link <a>..</a>
                    elseif(is_array($mxText))
                    {
                        $oMxText = new HelperAnchor();
                        $oMxText->set_href($mxText[0]);
                        $oMxText->set_innerhtml($mxText[1]);
                        $oMxText->add_class("label");
                    }
                    $oLi->add_inner_object($oMxText);
                }
                
                $oLi->add_class($this->sLiClass);
                $arLiObjects[] = $oLi;
            }
            $oUl->set_array_li($arLiObjects);
            $sHtmlToReturn .= $oUl->get_html();
        }
        
        $sHtmlToReturn .= $this->build_js();
        return $sHtmlToReturn;
    }//fin get_html

    private function get_fixed_params($isByMvc=0)
    {
        $arFixedKeys = array("module","section","view");
        if($isByMvc)
            $arFixedKeys = array("controller","partial","method");
        
        $arFixedParams = array();
        foreach($_GET as $key=>$mxValue)
            if(in_array($key,$arFixedKeys))
                $arFixedParams[$key] = "$key=$mxValue";
        return $arFixedParams;
    }
    
    private function get_unfixed_params()
    {
        $arFixedKeys = array("module","section","view","controller","partial","method");
        
        $arFixedParams = array();
        foreach($_GET as $key=>$mxValue)
            if(!in_array($key,$arFixedKeys))
                $arFixedParams[$key] = "$key=$mxValue";        
       
        return $arFixedParams;
    }
    
    protected function load_url_paginate()
    {
        $arFixed = $this->get_fixed_params();
        $arUnfixed = $this->get_unfixed_params();
        unset($arUnfixed["page"]);
        $this->sUrlPaginate = "?".implode("&",$arFixed);
        if($arUnfixed) 
            $this->sUrlPaginate .= "&".implode("&",$arUnfixed);
    }
    
    protected function build_hidden_fields()
    {
        $sHtmlHidden = "";
        $oHidden = new HelperInputHidden();
        $oHidden->set_id("hidOrderBy");
        $oHidden->set_name("hidOrderBy");
        $oHidden->set_value(implode(",",$this->arOrderBy));
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidOrderType");
        $oHidden->set_name("hidOrderType");
        $oHidden->set_value(implode(",",$this->arOrderWay));
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidUrlPaginate");
        $oHidden->set_name("hidUrlPaginate");
        $oHidden->set_value($this->sUrlPaginate);
        $sHtmlHidden .= $oHidden->get_html();

        $oHidden->set_id("hidAction");
        $oHidden->set_name("hidAction");
        $oHidden->set_value("");
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidPostback");
        $oHidden->set_name("hidPostback");
        $oHidden->set_value("");
        $sHtmlHidden .= $oHidden->get_html();        

        return $sHtmlHidden;
    }
    
    protected function build_navigation_buttons()
    {
        $sHtmlUlButtons = "";
        $arPages = array();
        for($i=1; $i<=$this->iInfoNumPages; $i++)
            $arPages[$i] = "pag $i";
        
        //bug($this->iInfoCurrentPage);
        $oSelPages = new HelperSelect($arPages,"selPage");
        $oSelPages->set_value_to_select($this->iInfoCurrentPage);
        //$oSelPages->add_class("span2");
        $oSelPages->add_style("margin:0;padding:0;width:85px;");
        $oSelPages->set_name("selPage");
        $oSelPages->set_js_onchange("table_frmsubmit();");
        
        $sHtmlSelect = $oSelPages->get_html();
        
        $sHtmlUlButtons .= "<ul style=\"margin:0\">";
        if($this->iInfoCurrentPage>1)
        {            
            $sHtmlUlButtons .= "<li><a href=\"javascript:nav_click($this->iInfoFirstPage);\">&nbsp;&nbsp;<span class=\"awe-arrow-left\"></span>&nbsp;&nbsp;</a></li>";
            $sHtmlUlButtons .= "<li><a href=\"javascript:nav_click($this->iInfoPreviousPage);\">&nbsp;&nbsp;«&nbsp;&nbsp;</a></li>";
        }        
        $sHtmlUlButtons .= "<li>&nbsp;Total: $this->iInfoNumRegs - ($this->iInfoCurrentPage/$this->iInfoNumPages)&nbsp;</li>";
        if($this->iInfoCurrentPage<$this->iInfoLastPage)        
        {
            $sHtmlUlButtons .= "<li><a href=\"javascript:nav_click($this->iInfoNextPage);\">&nbsp;&nbsp;»&nbsp;&nbsp;</a></li>";
            $sHtmlUlButtons .= "<li><a href=\"javascript:nav_click($this->iInfoLastPage);\">&nbsp;&nbsp;<span class=\"awe-arrow-right\"></span>&nbsp;&nbsp;</a></li>";
        }       

        if($this->iInfoNumPages>1) $sHtmlUlButtons .= "<li>&nbsp;&nbsp;Go to:&nbsp;&nbsp;$sHtmlSelect</li>";
        $sHtmlUlButtons .= "</ul>";
        return $sHtmlUlButtons;
    }

    protected function build_perpage_select()
    {
        $arItems = array("25"=>"25","100"=>"100","500"=>"500","1000"=>"1000");
        
        //bug($this->iInfoCurrentPage);
        $oSelPages = new HelperSelect($arItems,"selItemsPerPage");
        $oSelPages->set_value_to_select($this->iItempsPerPage);
        //$oSelPages->add_class("span2");
        $oSelPages->add_style("margin:0;padding:0;width:85px;");
        $oSelPages->set_name("selItemsPerPage");
        $oSelPages->set_js_onchange("table_frmsubmit();");

        $sHtmlSelect = $oSelPages->get_html();    
        $sHtmlUlButtons = "";
        $sHtmlUlButtons .= "<ul style=\"margin:0\">";
        $sHtmlUlButtons .= "<li>&nbsp;Page Items: $sHtmlSelect</li>";
        $sHtmlUlButtons .= "</ul>";
        return $sHtmlUlButtons;
    }
    
    protected function get_paginate_info()
    {
        //errorson();
        $sHtmlNavPages = 
        "
        <table id=\"tblNavPages\" style=\"width:100%; padding:0; margin-bottom:3px; margin-top:3px;\">
        <tr>
        <td style=\"background:#40444D; padding:0; color:white; border-radius: 4px 4px 4px 4px;\">
        <div class=\"pagination pagination-left\" style=\"padding:0;margin:0; margin-left:3px;\">";
        $sHtmlNavPages.= $this->build_navigation_buttons();
        $sHtmlNavPages.="</div>    
        </td>
        <td style=\"background:#40444D; padding:0; color:white; border-radius: 4px 4px 4px 4px;\">
        <div class=\"pagination pagination-left\" style=\"padding:0;margin:0; margin-left:3px;\">";
        $sHtmlNavPages.= $this->build_perpage_select();
        $sHtmlNavPages.="</div>    
        </td>        
        </tr>
        </table>
        ";
        return $sHtmlNavPages;
    }
    
    protected function js_fn_nav_click()
    {
        $sJs = "
        //helper_table_basic
        function nav_click(iPage)
        {
            var iPage = iPage || 1;
            var sUrlAction = TfwControl.get_value_by_id(\"hidUrlPaginate\");
            sUrlAction += \"&page=\"+iPage;
            TfwControl.sel_option_by_id(\"selPage\",iPage);
            TfwControl.form_submit(\"frmList\",sUrlAction);
        }
        ";
        return $sJs;        
    }
    
    protected function build_js()
    {
        $sHtmlJs .= "<script helper=\"tablebasic\" type=\"text/javascript\">\n";
        $sHtmlJs .= $this->js_fn_nav_click();
        $sHtmlJs .= $this->js_fn_form_submit();
        $sHtmlJs .= "</script>";
        return $sHtmlJs;
    }
    
    protected function js_fn_form_submit()
    {
        $sJs = "    
        //helper_table_basic
        function table_frmsubmit()
         {
            var iPage = TfwControl.get_value_by_id(\"selPage\");
            //alert(iPage);
            iPage = iPage || 1;
            var sUrlAction = TfwControl.get_value_by_id(\"hidUrlPaginate\");
            //DEPRECATED: sUrlAction += \"&page=\"+iPage;            
            TfwControl.form_submit(\"frmList\",sUrlAction);
         }
        ";
        return $sJs;        
    }    
    //**********************************
    //             SETS
    //**********************************
    /**
     * 
     * @param array $arLi i=>array(href=>,alt=>,src=>)
     */
    public function set_array_li($arLi){$this->arLi = $arLi;}
    public function set_raw($isOn=TRUE){$this->isRaw = $isOn;}
    public function set_title($value){$this->sTopTitle = $value;}
    public function set_text($value){$this->sTopText = $value;}
    public function set_li_class($value){$this->sLiClass = $value;}
    public function set_current_page($iNumPage){$this->iInfoCurrentPage=$iNumPage;}
    public function set_next_page($iNumPage){$this->iInfoNextPage=$iNumPage;}
    public function set_previous_page($iNumPage){$this->iInfoPreviousPage=$iNumPage;}
    public function set_total_regs($iNumRegs){$this->iInfoNumRegs=$iNumRegs;}
    public function set_total_pages($iNumPages){$this->iInfoNumPages=$iNumPages;}
    public function set_first_page($iNumFirstPage){$this->iInfoFirstPage=$iNumFirstPage;}
    public function set_last_page($iNumLastPage){$this->iInfoLastPage=$iNumLastPage;}
    public function set_items_per_page($iItemsPerPage){$this->iItempsPerPage=$iItemsPerPage;}
    public function set_fields($arObjFields){$this->arObjFields=$arObjFields;}      
    public function set_orderby($arFieldNames){$this->arOrderBy=$arFieldNames;}
    public function set_orderby_type($arOrderWay){$this->arOrderWay=$arOrderWay;}    
    
    //**********************************
    //             GETS
    //**********************************
}
