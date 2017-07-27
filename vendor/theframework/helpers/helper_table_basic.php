<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.8.0
 * @name HelperTableBasic
 * @date 18-02-2017 13:06 (SPAIN)
 * @file helper_table_basic.php
 * @requires
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
import_helper("select,form,form_fieldset,input_hidden,checkbox,table");
class HelperTableBasic extends HelperTable
{
    //Campos a crear antes del listado
    protected $arObjFields;
    protected $arKeyFields;
    //Colmnas (Cabecera)
    protected $arColumns;    
    //Filas de datos
    protected $arDataRows;
    //protected $arKeysDelete;
    //protected $arKeysDetail;
    //protected $arKeysPick;
    protected $arOrderBy;
    protected $sIdForm;
    protected $sUrlNoview;
    protected $sUrlDelete;
    protected $sUrlUpdate;
    protected $sUrlQuarantine;
    protected $sUrlPickSingle;
    protected $sUrlPickMultiple;
    protected $sUrlPaginate;
    protected $sModule;
    
    protected $arOrderWay;//asc|desc
    protected $isOrdenable;
    protected $isToDetail;//crea columna ir a detalle vista update
    
    protected $isPickMultiple; //crea columna con checks
    protected $isPickSingle; //de momento no tiene efectos
    protected $doMergePkeys;
    protected $isMergeKeyfields;
    protected $sMergeGlue;
    protected $arAssignSingle; //crea funcion js que permite lanzar popup con filas a seleccionar
    protected $arAssignMulti; // crea funcion js "
    protected $arMultiAdd; //funcion que ejecuta el post para realizar el proceso de asignacion
    protected $arSingleAdd; //funcion que ejecuta traspaso de valores por js a la ventana padre
    protected $arExtraColumns;
    protected $arHiddenColumns;
    protected $arExtraHidden;

    protected $arConfigColTypes;//los distintos formatos de las columnas. Fecha, hora4 hora6,fechahora4, fechahora6, decim
    protected $isDeleteSingle;//crea columna con boton eliminacion single
    protected $isQuarantineSingle;
    //arColumns=array(fieldname=>label);
    
    //INFO PAGINATE
    protected $iInfoNumRegs;
    protected $iInfoCurrentPage;
    protected $iInfoNumPages;
    protected $iInfoNextPage;
    protected $iInfoPreviousPage;
    protected $iInfoFirstPage;
    protected $iInfoLastPage;
    protected $iItemsPerPage;
    
    //rowcheckclick
    protected $isCheckOnRowclick;
    protected $isPaginateBar;
    
    protected $arTmpJs;
    protected $arColumnLength = [];
    
    public function __construct($arRows=[],$arColumns=[],$sIdForm="frmList",$sModule="")
    {
        //table,innert,classes,extra,style, parent=HelperTable
        //Mientras que helper table trabaja con $arObjTr HelperTableBasic Lo hace solo con array de datos
        //con estos array de datos posteriormente reutiliza arobjtr
        parent::__construct();
        $this->isPaginateBar = TRUE;
        $this->lower_fieldnames($arRows);
        $this->arDataRows = $arRows;
        $this->iNumRows = count($arRows);
        $this->arColumns = $arColumns;
        $this->iNumCols = count($arColumns);
        $this->sIdForm = $sIdForm;
        $this->_idprefix = "tbl";
        $this->_id = $sModule;
        $this->sModule = $sModule;
        //crea las urls que se guardaran en campos hidden para quarantine, delete, update
        $this->load_get_urls();
        $this->sMergeGlue=",";
        $this->arOrderBy = [];
        $this->arOrderWay = [];
        //bug($this->isPermaLink,"ispermalink en contruct"); die;
    }

    public function get_html()
    {
        $this->useThead = true;
        $this->useTfoot =true;
        
        $sHtmlToReturn = "";
        $oFieldset = new HelperFieldset();
        $oForm = new HelperForm($this->sIdForm);
        $oForm->add_class("form-horizontal");
        $oForm->add_style("margin:0;padding:0;border:0;");
        
        $sHtmlToReturn .= $oForm->get_opentag();
        $sHtmlToReturn .= $oFieldset->get_opentag();
        //"FILTROS"
        //Los campos que se mostrarán antes del listado. Suele ser para filtrs
        $sHtmlToReturn .= $this->get_fields_as_string();
        $sHtmlToReturn .= $oFieldset->get_closetag();
        //Barra de navegacion por paginas
        if($this->isPaginateBar)
            $sHtmlToReturn .= $this->build_paginate_bar();
        //crea la etiqueta table
        $sHtmlToReturn .= $this->get_opentag();
        //Filas.  Se carga en la propiedad arObjTrs de tfw_helper se utiliza el metodo tr_as_string
        //para imprimir en formato cadena el array de objetos de tipo Tr
        $this->load_array_object_tr();
        $sHtmlToReturn .= $this->get_html_rows();
        //Fin Filas
        $sHtmlToReturn .= $this->get_closetag();
        $sHtmlToReturn .= $this->build_hidden_fields();
        $sHtmlToReturn .= $oForm->get_closetag();
        //Fin formulario
        $sHtmlToReturn .= $this->build_js();
        return $sHtmlToReturn;
    }   
    
    protected function get_fields_as_string()
    {
        $sHtmlString = "";
        foreach($this->arObjFields as $arObjField)
            $sHtmlString .= $arObjField->get_html();
        return $sHtmlString;
    }

    protected function build_paginate_bar()
    {
        //errorson();
        $arPages = [];
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
        $sHtmlNavPages = 
        "
        <table id=\"tblNavPages\" style=\"width:100%; padding:0; margin-bottom:3px; margin-top:3px;\">
        <tr>
        <td style=\"background:#fff; padding:0; color:#003399;\">
        <div class=\"pagination pagination-left\" style=\"padding:0;margin:0; margin-left:3px;\">";
        $sHtmlNavPages.= $this->build_navigation_buttons($sHtmlSelect);
        $sHtmlNavPages.="</div>    
        </td>
        </tr>
        </table>
        ";
        return $sHtmlNavPages;
    }//build_paginate_bar
    
    /*
     * Para single return solo se envia el dato por js.
     * Necesito recuperar
     */
    protected function get_return_single()
    {
        //if(sIdNameKey) sUrlAction += \"&returnkey=\"+sIdNameKey;
        //if(sIdNameDesc) sUrlAction += \"&returndesc=\"+sIdNameDesc;
        $arJs = [];
        $sIdReturnKey = $this->get_get("returnkey");
        $sIdReturnDesc = $this->get_get("returndesc");
        $doClose = (int)$this->get_get("close");
        $arJs[] = "var sIdReturnKey=\"$sIdReturnKey\";";
        $arJs[] = "var sIdReturnDesc=\"$sIdReturnDesc\";";
        $arJs[] = "var doClose=$doClose;";
        return implode("\n",$arJs);        
    }
    
    protected function convert_to_urlparams($arForParams)
    {
        $arUrl = [];
        $cGlue = "&";
        if($this->isPermaLink)
        {
            $cGlue = "/";
            foreach($arForParams as $arParams)
                foreach($arParams as $sFieldName=>$sValue)
                    $arUrl[] = $sValue;
        }
        else
        {
            foreach($arForParams as $arParams)
                foreach($arParams as $sFieldName=>$sValue)
                    $arUrl[] = "$sFieldName=$sValue";
        }    
        $sUrl = implode($cGlue,$arUrl);
        return $sUrl;
    }
    
    protected function js_fn_multiassign_window()
    {
        $sJs = "
        function multiassign_window(sUrlAction,iW,iH,doClose)
        {
            var iW = iW || 800;
            var iH = iH || 600;
            var sUrlAction = sUrlAction || window.location.search;
            window.open(sUrlAction,\"multipick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);
        }
        ";
        return $sJs;
    }//js_fn_multiassign_window
    
    protected function js_fn_singleassign_window()
    {
        $this->set_tmpjs();
        if($this->isPermaLink)
        {
            $this->add_tmpjs("window.open(\"/\"+sUrlAction,\"singlepick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");   
        }
        else
        {
            $this->add_tmpjs("window.open(\"index.php?\"+sUrlAction,\"singlepick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");
        }
        
        $sTmpJs = $this->get_tmpjs();
        $sJs .= "
        function singleassign_window(sUrlAction,sIdNameKey,sIdNameDesc,iW,iH)
        {
            var iW = iW||800;
            var iH = iH||600;
            var sUrlAction = sUrlAction || window.location.search;
            $sTmpJs
        }
        ";
        return $sJs;
    }
    
    protected function js_fn_multiadd()
    {
        $sJs = "
        //helper_table_basic
        function multiadd(sUrlAction,sIdForm)
        {
            var sIdForm = sIdForm || \"$this->sIdForm\"; 
            var sUrlAction = sUrlAction || window.location.search;
            var oForm = document.getElementById(sIdForm);
            if(oForm)
            {
                if(is_checked(\"pkeys[]\"))
                {    
                    if(confirm(oTfwtr.confirm))
                    {
                        oForm.action=sUrlAction;
                        oForm.submit();
                    }
                }
                else
                    alert(oTfwtr.norows);
            }
        }
        ";
        return $sJs;        
    }

    protected function js_fn_singleadd()
    {
        $sJs = "
        //helper_table_basic
        function singleadd(iRow,sIdReturnKey,sIdReturnDesc,doClose)
        {
            var sHidKey = \"hidKeySingle_\"+iRow;
            var sHidDesc = \"hidDescSingle_\"+iRow;
            //window from: top: popup, opener:parent window la ventana que llama al popup
            var oWindowParent = top.opener;
            if(oWindowParent)
            {
                var sKeyValue = document.getElementById(sHidKey).value;
                var sDescValue = document.getElementById(sHidDesc).value;
                var eInput = oWindowParent.document.getElementById(sIdReturnKey);
                if(!eInput) eInput = oWindowParent.document.getElementsByName(sIdReturnKey)[0];
                if(eInput) eInput.value = sKeyValue;
                eInput = oWindowParent.document.getElementById(sIdReturnDesc);
                if(!eInput) eInput = oWindowParent.document.getElementsByName(sIdReturnDesc)[0];
                if(eInput) eInput.value = sDescValue;
                //cierra el popup
                if(doClose) self.close();
            }
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_form_submit()
    {
        //OJO CON ESTO es un parche. Tengo que ver pq ya no es util concatenar en la url la página
        //sin permalnk no se pasa page en la url ya que se envia selpage por post y en los even_postandget se genera 
        //el $_GET[page]. En permalink no me vale ya que tengo que pasar la pagina en la url para que pueda ser interpretado
        //por el router
        $sTmpJs = "";
        if($this->isPermaLink)
        {
            $this->set_tmpjs();
            $this->add_tmpjs("var iPage = TfwControl.get_value_by_id(\"selPage\");");
            $this->add_tmpjs("iPage = iPage || 1;");
            $this->add_tmpjs("sUrlAction += iPage + \"/\";");
            $sTmpJs = $this->get_tmpjs();
        }
        
        $sJs = "    
        //helper_table_basic
        function table_frmsubmit(sUrlAction,sIdForm)
        {            
            var sIdForm = sIdForm || \"$this->sIdForm\"; 
            var sUrlAction = sUrlAction || document.getElementById(\"hidUrlPaginate\").value;
            var oForm = document.getElementById(sIdForm);
            if(oForm)
            {
                $sTmpJs
                oForm.action=sUrlAction;
                oForm.submit();
            }
         }
        ";
        return $sJs;        
    }    
    
    protected function js_fn_rowcheck()
    {
        $sJs = "
        //helper_table_basic
        function rowcheck(iRow,id)
        {
            var id = id||\"pkeys\";
            id = id+\"_\"+iRow;
            //alert(id);return;
            var eCheckBox = document.getElementById(id);
            //alert(eCheckBox);
            if(eCheckBox)
            {
                if(TfwControl.is_checkbox_checked(eCheckBox))
                    TfwControl.set_checkbox_check(eCheckBox,0);
                else
                    TfwControl.set_checkbox_check(eCheckBox,1);
                rowchange(iRow);
            }
        }
        ";
        return $sJs;          
    }
    
    protected function js_fn_check_all()
    {
        $sJs = "
        //helper_table_basic
        function check_all(id,name)
        {
            var id = id||\"pkeys_all\";
            var name = name||\"pkeys[]\";
            var eCheckBox = document.getElementById(id);
            //alert(eCheckBox);
            if(TfwControl.is_checkbox_checked(eCheckBox))
                TfwControl.set_checked_by_name(name,true);
            else
                TfwControl.set_checked_by_name(name,false);
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_nav_click()
    {
        $this->set_tmpjs();
        if($this->isPermaLink)
        {
            $this->add_tmpjs("sUrlAction += iPage+\"/\";");
        }
        else
        {
            $this->add_tmpjs("sUrlAction += \"&page=\"+iPage;");
        }
        
        $sTmpJs = $this->get_tmpjs();   
        
        $sJs = "
        //helper_table_basic
        function nav_click(iPage)
        {
            var iPage = iPage || 1;
            var sUrlAction = TfwControl.get_value_by_id(\"hidUrlPaginate\");
            $sTmpJs
            TfwControl.sel_option_by_id(\"selPage\",iPage);
            TfwControl.form_submit(\"$this->sIdForm\",sUrlAction);
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_multi_delete()
    {
        $sCheckPostKey = $this->build_postkey();        
        $sJs = "    
        //helper_table_basic
        function multi_delete()
        {
            if(is_checked(\"$sCheckPostKey"."[]\"))
            {
                if(confirm(\"".tr_main_confirm_before_delete."\"))
                {   
                    var sUrlAction = document.getElementById(\"hidUrlNoview\").value;
                    sUrlAction = sUrlAction.replace(\"%replaceview%\",\"delete\");
                    var oHidAction = document.getElementById(\"hidAction\");
                    oHidAction.value = \"multidelete\";
                    TfwControl.form_submit(\"$this->sIdForm\",sUrlAction);
                }
            }
            else
                alert(\"".tr_main_table_selection."\");
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_multi_quarantine()
    {
        $sCheckPostKey = $this->build_postkey();
        
        $sJs = "
        //helper_table_basic
        function multi_quarantine()
        {
            if(is_checked(\"$sCheckPostKey"."[]\"))
            {
                if(confirm(\"".tr_main_confirm_before_quarantine."\"))
                {    
                    var sUrlAction = document.getElementById(\"hidUrlNoview\").value;
                    sUrlAction = sUrlAction.replace(\"%replaceview%\",\"quarantine\");
                    var oHidAction = document.getElementById(\"hidAction\");
                    oHidAction.value = \"multiquarantine\";                    
                    TfwControl.form_submit(\"$this->sIdForm\",sUrlAction);
                }
            }
            else
                alert(\"".tr_main_table_selection."\");
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_is_checked()
    {
        $sJs = "
        //helper_table_basic
        function is_checked(sCheckName)
        {
            var arObjChecks = document.getElementsByName(sCheckName);
            //bug(arObjChecks);
            if(arObjChecks.length!=undefined)
            {
                for(var i=0; i<arObjChecks.length; i++)
                    if(arObjChecks[i].checked==1)
                        return true;
            }
            return false;
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_rowchange()
    {
        $sJs = "
        //helper_table_basic
        function rowchange(iRow)
        {
            var sId = \"hidRowChanged_\"+iRow+\"_0\";
            var oHidRowChanged = document.getElementById(sId);
            //alert(oHidRowChanged);
            if(oHidRowChanged) oHidRowChanged.value=1;
        }
        ";
        return $sJs;        
    }
    
    protected function js_fn_hrefgo()
    {
        $sJs = "
        //helper_table_basic
        function hrefgo(sUrl,sConfirm)
        {
            var sConfirm = sConfirm || \"\";
            var sUrl = sUrl || \"\";
            if(sUrl!=\"\")
            {
                if(sConfirm!=\"\")
                {
                    if(confirm(sConfirm))
                        window.location = sUrl;
                }
                else
                {
                    window.location = sUrl;
                }
            }
        }
        ";
        return $sJs;         
    }
    
    protected function build_js()
    {
        $sHtmlJs = "<script helper=\"tablebasic.build_js\" type=\"text/javascript\">\n";
        $sHtmlJs .= $this->js_fn_rowchange();
        $sHtmlJs .= $this->js_fn_form_submit();
        $sHtmlJs .= $this->js_fn_check_all();
        $sHtmlJs .= $this->js_fn_nav_click();
        $sHtmlJs .= $this->js_fn_multi_delete();
        $sHtmlJs .= $this->js_fn_multi_quarantine();
        $sHtmlJs .= $this->js_fn_is_checked();
        $sHtmlJs .= $this->js_fn_hrefgo();
        if($this->isCheckOnRowclick)
            $sHtmlJs .= $this->js_fn_rowcheck();
        
        if($this->isOrdenable)
        {
            $sHtmlJs .= 
        "var sThBackground=\"\";
         var sThColor=\"\";
            
         function order_by(eTh)
         {
            var sFieldName = eTh.getAttribute(\"dbfield\");
            var oHidOrderBy = document.getElementById(\"hidOrderBy\");
            var oHidOrderType = document.getElementById(\"hidOrderType\");
            
            var sOrderBy = oHidOrderBy.value;
            var sOrderType = oHidOrderType.value;
            
            if(sOrderBy)
            {
                if(sFieldName==sOrderBy)
                {
                    if(sOrderType.toUpperCase()==\"ASC\")
                        oHidOrderType.value=\"DESC\";
                    else oHidOrderType.value=\"ASC\";
                }
                else
                {
                    oHidOrderBy.value = sFieldName;
                    oHidOrderType.value = \"ASC\";
                }
            }
            else
            {
                oHidOrderBy.value = sFieldName;
                oHidOrderType.value = \"ASC\";                
            }
            //bug('antes de submit');
            table_frmsubmit();
         }
         
         function on_thover(eTh,sColor,sBackColor)
         {
            sThBackground = eTh.style.backgroundColor;
            sThColor = eTh.style.color;
            eTh.style.color=sColor;
            eTh.style.backgroundColor=sBackColor;
         }
         
         function on_thout(eTh){eTh.style.backgroundColor=sThBackground;eTh.style.color=sThColor;}
        ";
        }
        
//        //Campos filtros
//        if($this->arObjFields)
//        {
//            $sFieldIds = $this->build_js_field_ids();
//            $sHtmlJs .="
//         function reset_filters()
//         {
//            var arFields = [$sFieldIds];
//            TfwFieldValidate.reset(arFields);
//         }
//        ";
//        }//hay arObjFields 
        
        //funcion js para popup
        if($this->arAssignMulti) $sHtmlJs .= $this->js_fn_multiassign_window();
        if($this->arMultiAdd) $sHtmlJs .= $this->js_fn_multiadd();
        if($this->arAssignSingle) $sHtmlJs .= $this->js_fn_singleassign_window();
        if($this->arSingleAdd) $sHtmlJs .= $this->js_fn_singleadd();
        $sHtmlJs .= "</script>\n";
        return $sHtmlJs;
    }
    
    protected function build_js_field_ids()
    {
        $arIds = array_keys($this->arColumns);
        $sFieldIds = implode("\",\"",$arIds);
        $sFieldIds = "\"$sFieldIds\"";
        return $sFieldIds;
    }
    
    protected function build_hidden_fields()
    {
        $sHtmlHidden = "";
        $oHidden = new HelperInputHidden();
        
        $oHidden->set_id("hidOrderBy");
        $oHidden->set_name("hidOrderBy");
        if($this->arOrderBy)
            $oHidden->set_value(implode(",",$this->arOrderBy));
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidOrderType");
        $oHidden->set_name("hidOrderType");
        if($this->arOrderWay)
            $oHidden->set_value(implode(",",$this->arOrderWay));
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidKeyFields");
        $oHidden->set_name("hidKeyFields");
        if($this->arKeyFields)
            $oHidden->set_value(implode(",",$this->arKeyFields));
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_name("hidUrlCurrent");
        $oHidden->set_id("hidUrlCurrent");
        $oHidden->set_value($this->get_request_uri());
        $sHtmlHidden .= $oHidden->get_html(); 
        
        //URLS: Solo para js
        $oHidden->set_name(NULL);
        $oHidden->set_id("hidUrlNoview");
        $oHidden->set_value($this->sUrlNoview);
        $sHtmlHidden .= $oHidden->get_html(); 
        
        //bug($this->sUrlPaginate);
        $oHidden->set_id("hidUrlPaginate");
        $oHidden->set_value($this->sUrlPaginate);
        $sHtmlHidden .= $oHidden->get_html();
        
        //creado como caja auxiliar para cualquier logica extra que se haga en la vista
        $oHidden->set_id("hidAuxiliar");
        $oHidden->set_name("hidAuxiliar");
        $oHidden->set_value("");
        $sHtmlHidden .= $oHidden->get_html();
        
        //Necesario para saber si solo se está refrescando, filtrando o eliminando
        $oHidden->set_id("hidAction");
        $oHidden->set_name("hidAction");
        $oHidden->set_value("");
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("hidPostback");
        $oHidden->set_name("hidPostback");
        $oHidden->set_value("");
        $sHtmlHidden .= $oHidden->get_html();
        
        $oHidden->set_id("selItemsPerPage");
        $oHidden->set_name("selItemsPerPage");
        $oHidden->set_value($this->iItemsPerPage);
        $sHtmlHidden .= $oHidden->get_html();        
        //Si se ha indicado que la tabla es de asignacion
        //se guarda los datos actuales de la url
        if($this->arAssignSingle)
        {
            $oHidden->set_id("hidAssignSingle");
            $oHidden->set_name("hidAssignSingle");
            $oHidden->set_value();
            $sHtmlHidden .= $oHidden->get_html();
        }           
        if($this->arAssignMulti)
        {
            $oHidden->set_id("hidAssignMulti");
            $oHidden->set_name("hidAssignMulti");
            $oHidden->set_value();
            $sHtmlHidden .= $oHidden->get_html();
        }     
        return $sHtmlHidden;
    }
    
    protected function build_hidden_row($iNumRow)
    {
        $oHidden = new HelperInputHidden();
        $sIdName = "hidRow_$iNumRow"."_0";
        $oHidden->set_id($sIdName);
        $oHidden->set_name($sIdName);
        $oHidden->set_value($iNumRow);
        return $oHidden->get_html();
    }
    
    protected function build_hidden_rowchange($iNumRow)
    {
        $oHidden = new HelperInputHidden();
        $sIdName = "hidRowChanged_$iNumRow"."_0";
        $oHidden->set_id($sIdName);
        $oHidden->set_name($sIdName);
        $oHidden->set_value("0");
        return $oHidden->get_html();
    }
    
    protected function build_hidden_keys($arRow,$iNumRow)
    {
        $sHtmlHidden = "";
        $oHidden = new HelperInputHidden();
        foreach($this->arKeyFields as $sFieldName)
        {
            $sIdName = "hid$sFieldName"."_$iNumRow";
            $oHidden->set_id($sIdName);
            $oHidden->set_name($sIdName);
            $oHidden->set_value($this->get_fieldvalue_by_name($arRow,$sFieldName));
            $sHtmlHidden .= $oHidden->get_html();            
        }
        return $sHtmlHidden;
    }

    protected function build_hidden_columns($arRow,$iNumRow)
    {
        $sHtmlHidden = "";
        $oHidden = new HelperInputHidden();
        if($this->arHiddenColumns)
            foreach($this->arHiddenColumns as $sFieldName)
            {
                $sIdName = "hid$sFieldName"."_$iNumRow"."_0";
                $oHidden->set_id($sIdName);
                $oHidden->set_name($sIdName);
                $oHidden->add_extras("cellpos",$iNumRow."_0");
                //bug($sFieldName);
                $oHidden->set_value($this->get_fieldvalue_by_name($arRow,$sFieldName));
                $sHtmlHidden .= $oHidden->get_html();            
            }
        return $sHtmlHidden;
    }

    protected function build_extra_hidden($iNumRow)
    {
        $sHtmlHidden = "";
        $oHidden = new HelperInputHidden();
        foreach($this->arExtraHidden as $sFieldName=>$mxValue)
        {
            $sIdName = "hid$sFieldName"."_$iNumRow"."_0";
            $oHidden->set_id($sIdName);
            $oHidden->set_name($sIdName);
            $oHidden->add_extras("cellpos",$iNumRow."_0");
            
            if(is_array($mxValue)) $mxValue = implode(",",$mxValue);
            $oHidden->set_value($mxValue);
            $sHtmlHidden .= $oHidden->get_html();            
        }
        return $sHtmlHidden;
    }
    
    /**
     * Crea el array de columnas incluyendo operaciones si las hubiese
     * Segun estas columnas crea la fila de cabecera
     * Segun las columnas crea las filas de datos 
     * @return array
     */
    protected function load_array_object_tr() 
    {
        //Devuelve las columnas de operaciones  Upd,Delete,Multiple
        $arColumns = $this->get_operation_columns();
        //bug($arColumns,"arcolumns antes");
        //Fila Cabecera. Añade la cabecera según las posiciones de las columnas
        $this->load_head_row($arColumns,$this->arObjTrs);
        //Filas Cuerpo. Añade las filas restantes según las posiciones de las columnas
        $this->load_body_rows($arColumns,$this->arObjTrs);
    }//load_array_object_tr
    
    protected function get_operation_columns()
    {
        $arColumns = [];
        if($this->isToDetail) $arColumns["detail"] = "Upd";
        if($this->isPickMultiple) $arColumns["multipick"] = "Multi";
        if($this->isPickSingle) $arColumns["singlepick"] = "Single";
        
        if(!empty($arColumns)) $arColumns = array_merge($arColumns,$this->arColumns);
        else $arColumns = $this->arColumns;
        
        if($this->isDeleteSingle) $arColumns["delete"] = "Del";
        if($this->isQuarantineSingle) $arColumns["quarantine"] = "Del";
        //bug($arColumns,"operation_columns");
        if($this->arExtraColumns) $arColumns = $this->reorder_columns($arColumns,$this->arExtraColumns);
        return $arColumns;
    }
    
    protected function reorder_columns($arColumns,$arVirtualColumns)
    {
        $arColsReordered = [];
        $arOccupied = [];
        $arTemp = [];

        foreach($arColumns as $sFieldName=>$sLabel)
        {
            $iPosition = array_key_position($sFieldName,$arColumns);
            $arOccupied[] = array("fieldname"=>$sFieldName,"label"=>$sLabel,"position"=>$iPosition);
        }

        foreach($arOccupied as $i=>$arColumnOccupied)
        {
            $sFieldName = $arColumnOccupied["fieldname"];
            $sLabel = $arColumnOccupied["label"];
            $iPosition = $arColumnOccupied["position"];

            $arNewInPosition = $this->get_columns_by_position($iPosition,$arVirtualColumns);
            foreach($arNewInPosition as $i=>$arNewCol)
                $arTemp[] = $arNewCol;

            $arTemp[] = $arColumnOccupied;
            $this->unset_by_position($iPosition,$arVirtualColumns);
        }    

        //Fuera del rango de los que existian
        foreach($arVirtualColumns as $i=>$arData)
        {
            $arData["fieldname"] = "virtual_$i";
            $arTemp[] = $arData;
        }

        foreach($arTemp as $arData)
            $arColsReordered[$arData["fieldname"]]=$arData["label"];  
        //bug($arColsReordered); die;
        return $arColsReordered;
    }

    protected function get_columns_by_position($iPosition,$arColumns)
    {
        $arColsInPosition = [];
        foreach($arColumns as $i=>$arColData)
            if($arColData["position"]==$iPosition)
            {
                $arColData["fieldname"] = "virtual_$i";
                $arColsInPosition[] = $arColData;
            }
        return $arColsInPosition;
    }
    
    protected function unset_by_position($iPosition,&$arColums)
    {
        foreach($arColums as $key=>$arColData)
            if($arColData["position"]==$iPosition)
                unset($arColums[$key]);
    }

    protected function load_head_row($arColumns,&$arObjRows)
    {
        $oTrHead = new HelperTableTr();
        $oTrHead->set_as_rowhead();
        $oTrHead->set_attr_rownumber(-1);
        //bug($arColumns,"arColumns");die;
        //Cabecera
        foreach($arColumns as $sFieldName=>$sLabel)
        {
            $iColumnPosition = array_key_position($sFieldName,$arColumns);
            //bug($sFieldName,$iNumColumn);
            $oTh = new HelperTableTd();
            $oTh->set_as_header();
            $oTh->set_attr_dbfield($sFieldName);
            $oTh->set_attr_colnumber($iColumnPosition);
            $oTh->set_attr_rownumber(-1);
            switch($sFieldName)
            {
                case "multipick":
                    //Al ser multipick es una columna checkbox sin label
                    $oTh->set_innerhtml($this->build_multiple_button_head());
                break;
                default:
                    $sColLabel = $this->build_column_label($sFieldName,$sLabel);
                    $oTh->set_innerhtml($sColLabel);
                    //bug($oTh,$sFieldName);
                    //si la tabla permite ordenar se aplica la func js para ejecutar el submit
                    $arNoOrder=array("delete","detail","singlepick","quarantine");
                    if($this->isOrdenable && !(in_array($sFieldName,$arNoOrder) || strstr($sFieldName,"virtual_")))
                    {    
                        $oTh->set_js_onclick("order_by(this);");
                        $oTh->set_js_onmouseover("on_thover(this,'#000','#B2B2B2');");
                        $oTh->set_js_onmouseout("on_thout(this);");
                    }
                break;
            }//fin switch fieldname
            $arObjThs[] = $oTh;
        }
        $oTrHead->set_objtds($arObjThs);
        //array con celdas cabecera
        $arObjRows[] = $oTrHead;
        //Fin cabecera        
    }//fin load_head_row
    
    protected function build_column_label($sFieldName,$sLabel)
    {
        //bug($this->arOrderBy,"arOrdeBy");bug($this->arOrderWay,"arOrderWay");
        $sColumnHeader = $sLabel;
        if($this->isOrdenable && $this->arOrderBy)
        {
            //bug($this->arOrderBy,$sFieldName);bug($this->arOrderWay);
            $iPosition = array_search($sFieldName,array_values($this->arOrderBy));
            //bug($iPosition,"position $sFieldName");
            if($iPosition || $iPosition===0) $sOrderWay = $this->arOrderWay[$iPosition];
            //bug($sOrderWay,"orderway");
            if($sOrderWay=="ASC")
                $sColumnHeader = "$sColumnHeader <span class=\"awe-caret-up\"></span>";
            elseif($sOrderWay=="DESC")
                $sColumnHeader = "$sColumnHeader <span class=\"awe-caret-down\"></span>";
            //else  Aqui deberia dar errores
        }  
        //bug($sColumnHeader,"columnHeader: $sFieldName, $sLabel");
        return $sColumnHeader;
    }//build_column_label

    protected function load_body_rows($arColums,&$arObjRows)
    {
        //Recorre las filas de datos
        foreach($this->arDataRows as $iNumRow=>$arRow)
        {
            //Celdas de la fila
            $arObjTds = [];
            $oTr = new HelperTableTr();
            
            if($this->isCheckOnRowclick)  
            {    
                $sPostKey = $this->build_postkey();
                $oTr->set_js_onclick("rowcheck('$iNumRow','$sPostKey');");
                //$oTr->set_js_onchange("alert('changed')");//no escucha este evento
            }
            
            $oTr->set_attr_rownumber($iNumRow);
            //Recorre las columnas segun el orden pasado en las cabeceras
            foreach($arColums as $sFieldName=>$sLabel)
            {
                $iNumColumn = (int)array_key_position($sFieldName,$arColums);
                $oTd = new HelperTableTd();
                $oTd->set_attr_dbfield($sFieldName);
                $oTd->set_attr_colnumber($iNumColumn);
                $oTd->set_attr_rownumber($iNumRow);
                $oTd->set_attr_position($iNumRow,$iNumColumn);
                //CONTENIDO DE CELDA
                $sTdInner = $this->build_cell_content($arRow,$sFieldName,$iNumRow,$iNumColumn);
                $oTd->set_innerhtml($sTdInner);
                $arObjTds[] = $oTd;
            }//fin for arColumns
            $oTr->set_objtds($arObjTds);
            $arObjRows[] = $oTr;
        }//fin for arDataRows
    }//load_body_rows

    /**
     * ___MAIN_CELL__
     * Segun el nombre de la columna, ya sea relacionada con un campo en bd y/o con una operacion agregada
     * se genera su contenido.
     * @param array $arRow Array de pares columna=>valor
     * @param string $sFieldName Nombre de la columna a la que corresponde la celda
     * @param integer $iNumRow Numero de la fila. Se utiliza para crear el atributo de posicion de celda
     * @param integer $iNumColumn Numero de la columna. Se utiliza para crear los hiddenkeys y la posicion de la celda
     * @return string Html con contenido de la celda
     */
    protected function build_cell_content($arRow,$sFieldName,$iNumRow,$iNumColumn)
    {
        $sTdInner = "";
        if($iNumColumn===0)
        {   
            $sTdInner .= $this->build_hidden_rowchange($iNumRow);
            $sTdInner .= $this->build_hidden_row($iNumRow);
            $sTdInner .= $this->build_hidden_keys($arRow,$iNumRow);
            $sTdInner .= $this->build_hidden_columns($arRow,$iNumRow);
            if($this->arHiddenColumns)
                $sTdInner .= $this->build_extra_hidden($iNumRow);
        }
        //corrige los valores que van dentro de <td>. Leen this->arColumnLngth
        $this->fix_length($arRow,$sFieldName);
        $arRow[$sFieldName] = htmlentities($arRow[$sFieldName]);
        
        switch($sFieldName)
        {
            //columna delete single
            case "delete":
                $sTdInner .= $this->build_delete_button($arRow);
            break;
            case "quarantine":
                $sTdInner .= $this->build_quarantine_button($arRow);
            break;        
            case "detail":
                $sTdInner .= $this->build_detail_button($arRow);
            break;
            case "multipick":
                //bug($oChekbox);
                $sTdInner .= $this->build_multiple_button($arRow,$iNumRow);
            break;
            case "singlepick":
                $sTdInner .= $this->build_single_button($arRow,$iNumRow);
                //bug($sTdInner,"tdinner");
            break;         
            default:
                $sTdInner .= $this->get_fieldvalue_by_name($arRow,$sFieldName);
            break;
        }//fin switch fieldname
        return $sTdInner;
    }

    protected function build_url_button($sUrlMethod,$arRow,$sExclude=NULL)
    {
        $sReturnUrl = $sUrlMethod;
        $sKeys = $this->get_keys_as_url($arRow,$sExclude);
        
        if($this->isPermaLink)
        {
            //si no acaba en / le añado esta
            if(!$this->is_lastchar_slash($sReturnUrl))
                $sReturnUrl = $sUrlMethod."/";

            if($sKeys) $sReturnUrl.=$sKeys."/";
            
        }
        elseif($sKeys)
            $sReturnUrl.="&".$sKeys; 
        
        return $sReturnUrl;
    }
    
    protected function build_delete_button($arRow)
    {
        $oAnchor = new HelperAnchor();
        $oAnchor->add_class("btn btn-danger");
        //icon-remove-sign
        $oAnchor->set_innerhtml("\n<span class=\"awe-remove-sign\"></span> ".tr_main_list_delete);
        $oAnchor->set_target("self");
        $sUrlButton = $this->build_url_button($this->sUrlDelete,$arRow);
        $oAnchor->set_href("javascript:hrefgo('$sUrlButton','".tr_main_confirm_before_delete."');");
        $sHtmlAnchor .= $oAnchor->get_html();
        return $sHtmlAnchor;
    }

    protected function build_quarantine_button($arRow)
    {
        $oAnchor = new HelperAnchor();
        $oAnchor->add_class("btn btn-danger");
        //icon-remove-sign
        $oAnchor->set_innerhtml("\n<span class=\"awe-remove-sign\"></span> ".tr_main_list_quarantine);
        $oAnchor->set_target("self");
        $sUrlButton = $this->build_url_button($this->sUrlQuarantine,$arRow);
        $oAnchor->set_href("javascript:hrefgo('$sUrlButton','".tr_main_confirm_before_quarantine."');");
        $sHtmlAnchor .= $oAnchor->get_html();
        return $sHtmlAnchor;
    }
    
    protected function build_detail_button($arRow)
    {
        $oAnchor = new HelperAnchor();
        $oAnchor->add_class("btn btn-info");
        $oAnchor->set_innerhtml("\n<span class=\"awe-info-sign\"></span> info");
        $oAnchor->set_target("self");
        $sUrlButton = $this->build_url_button($this->sUrlUpdate,$arRow,"page");
        $oAnchor->set_href($sUrlButton);
        $sHtmlAnchor .= $oAnchor->get_html();
        return $sHtmlAnchor;
    }

    protected function build_multiple_button($arRow,$iNumRow="")
    {
        $oChekbox = new HelperCheckbox();
        $oChekbox->set_unlabeled();
        $sHtmlCheck = "";
        
        if($this->doMergePkeys)
        {
            foreach($this->arKeyFields as $sFldKeyName)
                $arValues[] = $sFldKeyName."=".$this->get_fieldvalue_by_name($arRow,$sFldKeyName);
            
            $sMerged = implode($this->sMergeGlue,$arValues);
            $oChekbox->set_options(array($sMerged=>NULL));
            $oChekbox->set_id("pkeys_$iNumRow");
            $oChekbox->set_name("pkeys");
            $oChekbox->set_attr_dbfield("pkeys");
            //$oChekbox->set_js_onchange("alert('hola')");
            $sHtmlCheck .= $oChekbox->get_html();            
        }    
        else
        //TODO: Esto habría que mejorarlo. Se debe añadir el atributo
        //name por js cuando se active el check y quitarlo cuando se desactiva
        //para evitar dos check en una celda Así pues cuando se envie el formulario
        //llegaran por post solo los hidden con nombre
        foreach($this->arKeyFields as $sFldKeyName)
        {
            $sFieldValue = $this->get_fieldvalue_by_name($arRow,$sFldKeyName);
            $oChekbox->set_options(array($sFieldValue=>""));
            $id = $sFldKeyName;
            if($iNumRow!=="") $id .= "_$iNumRow";
            $oChekbox->set_id($id);
            //Cambio en el helper Checkbox. No hace falta [] ya que se activa o desactiva según la variable isGrouped. Por defecto true
            $oChekbox->set_name($sFldKeyName);
            $oChekbox->set_attr_dbfield($sFldKeyName);
            //$oChekbox->set_js_onchange("alert('hola')");
            $sHtmlCheck .= $oChekbox->get_html();
        }
        return $sHtmlCheck;
    }//build_multiple_button

    protected function build_single_button($arRow,$iNumRow="")
    {
        //array("destkey"=>"txtCode","destdesc"=>"txtCodeErp","keys"=>"id","descs"=>"description,bo_login","close"=>1)
        $sIdDestKey = $this->arSingleAdd["destkey"];
        $sIdDestDesc = $this->arSingleAdd["destdesc"];
        $arColumnsKeys = explode(",",$this->arSingleAdd["colkeys"]);
        $arColumnsDesc = explode(",",$this->arSingleAdd["coldescs"]);
        $doClose = (int)$this->arSingleAdd["close"];
        
        $oButton = new HelperButtonBasic();
        $oButton->add_class("btn btn-success");
        $oButton->set_innerhtml("Pick");
        $oHidKey = new HelperInputHidden("hidKeySingle_$iNumRow");        
        $oHidDesc = new HelperInputHidden("hidDescSingle_$iNumRow");

        $oButton->set_js_onclick("singleadd($iNumRow,'$sIdDestKey','$sIdDestDesc',$doClose);");

        $sHtmlButton = "";
        
        $iNumFields = count($arColumnsKeys);
        foreach($arColumnsKeys as $sFieldName)
            if($iNumFields>1)
                $arValues[] = $sFieldName."=".$this->get_fieldvalue_by_name($arRow,$sFieldName);
            else
                $arValues[] = $this->get_fieldvalue_by_name($arRow,$sFieldName);

        $sMerged = implode($this->sMergeGlue,$arValues);
        $oHidKey->set_value($sMerged);

        $arValues = [];
        //$iNumFields = count($arColumnsDesc);
        foreach($arColumnsDesc as $sFieldName)
            $arValues[] = $this->get_fieldvalue_by_name($arRow,$sFieldName);
        
        $sMerged = implode($this->sMergeGlue,$arValues);
        $oHidDesc->set_value($sMerged);

        $sHtmlButton .= $oButton->get_html();
        $sHtmlButton .= $oHidKey->get_html();
        $sHtmlButton .= $oHidDesc->get_html();        
        return $sHtmlButton;
    }//build_single_button
    
    protected function build_multiple_button_head()
    {
        $oChekbox = new HelperCheckbox();
        $oChekbox->set_unlabeled();
        $sHtmlCheck = "";
        if($this->doMergePkeys)
        {
            $sFldKeyNames = implode($this->sMergeGlue,array_values($this->arKeyFields));
            $oChekbox->set_options(array($sFldKeyNames=>NULL));
            $oChekbox->set_id("pkeys_all");
            $oChekbox->set_name("pkeys_all");
            $oChekbox->set_js_onclick("check_all();");
            $sHtmlCheck .= $oChekbox->get_html();
        }    
        else//No es un keymerge entonces se crea una caja por key
            foreach($this->arKeyFields as $sFldKeyName)
            {
                $oChekbox->set_options(array($sFldKeyName=>NULL));
                $oChekbox->set_id($sFldKeyName."_all");
                $oChekbox->set_name($sFldKeyName."_all");
                $oChekbox->set_js_onclick("check_all('$sFldKeyName"."_all','$sFldKeyName"."[]');");
                $sHtmlCheck .= $oChekbox->get_html();
            }
            return $sHtmlCheck;
    }
    
    protected function get_keys_as_url($arRow,$mxExclude=NULL)
    {
        //Necesario para poder excluir parámetros que no se usan con .htcacces en los links
        //y que dificultan el enrutamiento ej. module=xxx&page=3&update=65.  "page" sobra
        $arExclude = $this->mixed_to_array($mxExclude);
        $arRowKeys = [];
        $cGlue = "&";
        
        if($this->isPermaLink)
        {
            foreach($this->arKeyFields as $sFldKeyName)
            {
                if(in_array($sFldKeyName,$arExclude))
                    continue;
                $sFieldValue = $this->get_fieldvalue_by_name($arRow,$sFldKeyName);
                if($sFieldValue) 
                    $arRowKeys[] = $sFieldValue;
            }            
        }
        else
        {
            foreach($this->arKeyFields as $sFldKeyName)
            {
                if(in_array($sFldKeyName,$arExclude))
                    continue;                
                $sFieldValue = $this->get_fieldvalue_by_name($arRow,$sFldKeyName);
                if($sFieldValue) 
                    $arRowKeys[] = "$sFldKeyName=$sFieldValue";
            }
        }
        $sUrl = implode($cGlue,$arRowKeys);
        return $sUrl;
    }
    
    protected function get_keys_as_string($arRow,$mxExclude=NULL,$isWithName=0)
    {
        $arRowKeys = [];
        $cGlue = ",";
        $arExclude = $this->mixed_to_array($mxExclude);
        foreach($this->arKeyFields as $sFldKeyName)
        {
            if(in_array($sFldKeyName,$arExclude)) continue;   
            $sFieldValue = $this->get_fieldvalue_by_name($arRow,$sFldKeyName);
            if($isWithName)
                $arRowKeys[] = "$sFldKeyName:$sFieldValue";
            else
                $arRowKeys[] = $sFieldValue;
        }
        $sKeys = implode($cGlue,$arRowKeys);
        return $sKeys;
    }
    
    protected function get_fieldvalue_by_name($arRow,$sName)
    {
        foreach($arRow as $sFieldName=>$sFieldValue)
        {    
            if($sFieldName==$sName)
            {    
                $sFieldValue = $this->get_formated_value($sFieldName,$sFieldValue);
                return $sFieldValue;
            }
        }
        return NULL;
    }    
    
    protected function get_colformat($sFieldName)
    {
        foreach($this->arConfigColTypes as $sField=>$sFormat)
            if($sFieldName==$sField)
                return $sFormat;
        return NULL;
    }
    
    /**
     * Este metodo se llama igual que en theframework con la diferencia que este transforma un valor de bd a bo
     * de modo que se muestre en un formato entendido por el usuario
     * @param string $sFieldName
     * @param string $sFieldValue
     * @return formated value
     */
    protected function get_formated_value($sFieldName,$sFieldValue)
    {
        $sValue = "";
        $sFormat = $this->get_colformat($sFieldName);
        switch($sFormat) 
        {
            case "date":
                $sValue = dbbo_date($sFieldValue);
            break;
        
            case "datetime4":
                $sValue = dbbo_datetime4($sFieldValue);
            break;

            case "datetime6":
                $sValue = dbbo_datetime6($sFieldValue);
            break;

            case "time4":
                $sValue = dbbo_time4($sFieldValue);
            break;

            case "time6":
                $sValue = dbbo_time6($sFieldValue);
            break;

            case "int":
                $sValue = dbbo_int($sFieldValue);
            break;
        
            case "numeric2":
                $sValue = dbbo_numeric2($sFieldValue);
            break;
        
            default:
                $sValue = $sFieldValue;
            break;
        }
        //bug($sValue,$sFieldName);
        return $sValue;
    }        
    
    protected function build_navigation_buttons($sHtmlSelect)
    {
        $sHtmlUlButtons = "";
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

    private function build_url_nomethod($isByMvc=0)
    {
        $arUrlNoMethod = [];
        if($this->isPermaLink)
        {
            //bugg();
            if(isset($_GET["tfw_iso_language"])) 
                $arUrlNoMethod[0] = $_GET["tfw_iso_language"]; 
            
            if($isByMvc)
            {
                if(isset($_GET["tfw_package"])) $arUrlNoMethod[1] = $_GET["tfw_package"];
                if(isset($_GET["tfw_controller"])) $arUrlNoMethod[2] = $_GET["tfw_controller"];
                if(isset($_GET["tfw_partial"])) $arUrlNoMethod[3] = $_GET["tfw_partial"];           
            }
            //isByMvc=0
            else
            {
                if(isset($_GET["tfw_group"])) $arUrlNoMethod[1] = $_GET["tfw_group"];
                if(isset($_GET["tfw_module"])) $arUrlNoMethod[2] = $_GET["tfw_module"];
                if(isset($_GET["tfw_section"])) $arUrlNoMethod[3] = $_GET["tfw_section"];
            }
            return implode("/",$arUrlNoMethod);
        }
        //no permalink
        else
        {
            if(isset($_GET["tfw_iso_language"])) 
                $arUrlNoMethod[1] = "lang=".$_GET["tfw_iso_language"];
            
            if($isByMvc)
            {
                if($_GET["tfw_package"]) $arUrlNoMethod[1] = "package=".$_GET["tfw_package"];
                if($_GET["tfw_controller"]) $arUrlNoMethod[2] = "controller=".$_GET["tfw_controller"];
                if($_GET["tfw_partial"]) $arUrlNoMethod[3] = "partial=".$_GET["tfw_partial"];
            }
            //isByMvc=0
            else
            {
                if($_GET["tfw_group"]) $arUrlNoMethod[1] = "group=".$_GET["tfw_group"];
                if($_GET["tfw_module"]) $arUrlNoMethod[2] = "module=".$_GET["tfw_module"];
                if($_GET["tfw_section"]) $arUrlNoMethod[3] = "section=".$_GET["tfw_section"];
            }
            return implode("&",$arUrlNoMethod);
        }
    }//build_url_nomethod
    
    private function build_url_extras()
    {
        $arGet = $_GET;
        //bugg();
        $arRemove = array("tfw_iso_language","tfw_group","tfw_module","tfw_section","tfw_view"
                                        ,"tfw_package","tfw_controller","tfw_partial","tfw_method"
                          ,"page","selPage");
        //limpio los get
        foreach($arGet as $sParam=>$sValue)
            if(in_array($sParam,$arRemove))
                unset($arGet[$sParam]);
            
        if($this->isPermaLink)
        {
            return implode("/",$arGet);
        }
        //no permalink
        else
        {
            $arUrl = [];
            foreach($arGet as $sParam=>$sValue)
                $arUrl[] = "$sParam=$sValue";            
            return implode("&",$arUrl);
        }
    }//build_url_extras
    
    /**
     * @@paginateurl
     * @return string
     */
    private function get_paginate_view()
    {
        $sView = $_GET["tfw_view"];
        if(!$sView) $sView = $_GET["tfw_method"];
        if(!$sView) 
            return "get_list";
        else 
            return $sView;
    }
    
    /**
     * @@paginateurl
     * @param type $isByMvc
     */
    protected function load_get_urls($isByMvc=0)
    {
        $sUrlNoMethod = $this->build_url_nomethod($isByMvc);
        //pr($sUrlNoMethod);
        $sUrlExtras = $this->build_url_extras($isByMvc);
        
        //las sUrl update,delete,quarantine se usan para los botones de acciones en los listados
        //los href:this->sUrl<action>
        if($this->isPermaLink)
        {   
            $this->sUrlNoview = "/$sUrlNoMethod/%replaceview%/";
            $this->sUrlDelete = "/".$sUrlNoMethod."/delete/";
            $this->sUrlUpdate = "/".$sUrlNoMethod."/update/";
            $this->sUrlQuarantine = "/".$sUrlNoMethod."/quarantine/";
            $this->sUrlPaginate = "/".$sUrlNoMethod."/";
            
            //CONFLICTO ENTRE DOS TIPOS DE RUTAS:
            //(en|es)/adminpannel/orders/orderlines/:id_order_head:[0-9]+:id_order_head:/:page:^(\s*|\d+)$:page:/
            //para esta, puesto que es una vista listado omito en la url "get_list" pq se sobre entiende
            //adminpannel/products/multiassign/12/ -> para esta necesito get_paginate_view
            //la paginación comun no lleva vista, pero la paginación en pestaña no es común (puede y no llevar), 
            //para la paginación en popup (multiassign y singleassign) tiene que llevar
            if(in_array($_GET["tfw_view"],["multiassign","singleassign"]))
                $this->sUrlPaginate .= "{$_GET["tfw_view"]}/";
            
            if($sUrlExtras)
            {
                $this->sUrlNoview .= "$sUrlExtras/";
                $this->sUrlDelete .= "$sUrlExtras/";
                $this->sUrlUpdate .= "$sUrlExtras/";
                $this->sUrlQuarantine .= "$sUrlExtras/";
                $this->sUrlPaginate .= "$sUrlExtras/";                
            }
        }
        //no permalink
        else
        {
            $this->sUrlNoview = "?$sUrlNoMethod&view=%replaceview%";
            $this->sUrlDelete = "?".$sUrlNoMethod."&view=delete";
            $this->sUrlUpdate = "?".$sUrlNoMethod."&view=update";
            $this->sUrlQuarantine = "?".$sUrlNoMethod."&view=quarantine";
            //la paginación puede trtatarse de 4 formas noview,get_list,singleassign y multiassign
            $this->sUrlPaginate = "?".$sUrlNoMethod;
            //segun $_GET[view|method]
            $this->sUrlPaginate .= "&view=".$this->get_paginate_view();
            
            if($sUrlExtras)
            {
                $this->sUrlNoview .= "&$sUrlExtras";
                $this->sUrlDelete .= "&$sUrlExtras";
                $this->sUrlUpdate .= "&$sUrlExtras";
                $this->sUrlQuarantine .= "&$sUrlExtras";
                $this->sUrlPaginate .= "&$sUrlExtras";                
            }
        }
       //bug($this->sUrlPaginate,"urlpaginate.load_get_urls");
    }//load_get_urls()
    
    /**
     * Si se está usando mergekeys devolvera pkeys ya que los controles check
     * se crearán con con ids pkeys_i, si no se usa mergekeys entonces se crean los 
     * controles con nombre tipo key1key2key3_0, key1key2key3_1 ... key1key2key3_n
     * @return string
     */
    protected function build_postkey()
    {
        $sCheckName = "";
        if($this->doMergePkeys)
            $sCheckName = "pkeys";
        else
            foreach($this->arKeyFields as $sFldKeyName)
               $sCheckName .=$sFldKeyName;
        return $sCheckName;
    }
    
    protected function lower_fieldnames(&$arRows)
    {
        $arLowered = [];
        if(is_array($arRows))
            foreach($arRows as $i=>$arRow)
            {
                $arTmpRow = [];
                foreach($arRow as $sFieldName=>$sValue)
                {    
                    $sFieldName = strtolower($sFieldName);
                    $arTmpRow[$sFieldName] = $sValue; 
                }
                $arLowered[$i] = $arTmpRow;
            }
        $arRows=$arLowered;
    }
    
    protected function fix_length(&$arRow,$sFieldName)
    {
        //check if exists in array $this->arColumnLength
        if($this->has_column_length($sFieldName))
        {
            $sValue = $arRow[$sFieldName];
            $iLenVal = strlen($sValue);
            $iLenConf = $this->get_column_length($sFieldName);
            //bug("f:$sFieldName,conflen:$iLenConf,valen:$iLenVal");
            if($iLenVal>$iLenConf)
            {
                //$sValue = htmlentities($sValue);
                $sValue = substr($sValue,0,$iLenConf)."...";
                $arRow[$sFieldName] = $sValue;
            }
        }
    }
    //**********************************
    //             SETS
    //**********************************
    protected function set_tmpjs($mxValues=NULL)
    {
        $this->arTmpJs=[];
        if(is_array($mxValues))
            $this->arTmpJs = $mxValues;
        elseif($mxValues)
            $this->arTmpJs[] = $mxValues;
    }
    
    protected function add_tmpjs($sJsString)
    {
        if($sJsString!==NULL)
            $this->arTmpJs[] = $sJsString;
    }
    
    public function set_column_detail($isOn=true){$this->isToDetail=$isOn;}
    public function set_column_delete($isOn=true){$this->isDeleteSingle=$isOn;}
    public function set_column_quarantine($isOn=true){$this->isQuarantineSingle=$isOn;}
    public function set_column_pickmultiple($isOn=true){$this->isPickMultiple=$isOn;}
    public function merge_pks($isOn=true,$sGlue=","){$this->doMergePkeys=$isOn; $this->sMergeGlue=$sGlue;}
    public function set_column_picksingle($isOn=true){$this->isPickSingle=$isOn;}    
    public function set_keyfields($arKeyFields){$this->arKeyFields=$arKeyFields;}
    public function set_orderby($arFieldNames){$this->arOrderBy=$arFieldNames;}
    public function set_orderby_type($arOrderWay){$this->arOrderWay=$arOrderWay;}
    public function set_url_delete($sUrl){$this->sUrlDelete=$sUrl;}
    public function set_url_quarantine($sUrl){$this->sUrlQuarantine=$sUrl;}
    public function set_url_update($sUrl){$this->sUrlUpdate=$sUrl;}
    /**
     * Sirve para rescribir la url a donde senviara el formulario. 
     * Es útil en caso de no cumplir con el standard de direcciones de theframework
     * @param string $sUrl
     */
    public function set_url_paginate($sUrl){$this->sUrlPaginate=$sUrl;}
    public function set_url_picksingle($sUrl){$this->sUrlPickSingle=$sUrl;}
    
    /**
     * Asigna el módulo y aplica las urls
     * @param string $sModule Modulo que gestiona el listado
     * cuando se usa esto??? deprecated por inclusion de load_get_urls()
     * Esto me rompe la paginación en las pestañas foreign
     */
    public function set_module($sModule)
    {

    }//set_module
    
    public function set_current_page($iNumPage){$this->iInfoCurrentPage=$iNumPage;}
    public function set_next_page($iNumPage){$this->iInfoNextPage=$iNumPage;}
    public function set_previous_page($iNumPage){$this->iInfoPreviousPage=$iNumPage;}
    public function set_total_regs($iNumRegs){$this->iInfoNumRegs=$iNumRegs;}
    public function set_total_pages($iNumPages){$this->iInfoNumPages=$iNumPages;}
    public function set_first_page($iNumFirstPage){$this->iInfoFirstPage=$iNumFirstPage;}
    public function set_last_page($iNumLastPage){$this->iInfoLastPage=$iNumLastPage;}
    public function set_fields($arObjFields){$this->arObjFields=$arObjFields;}
    public function is_ordenable($isOn=true){$this->isOrdenable=$isOn;}
    public function set_check_onrowclick($isOn=true){$this->isCheckOnRowclick=$isOn;}
    
    /**
     * Datos que se desean pasar al popup por la url.
     * @param array $arData = array("keys"=>array("fieldname"=>value...),"extras"=>array("key"=>value..));
     */
    public function set_multiassign($arData){$this->arAssignMulti=$arData;}  
    public function set_singleassign($arData){$this->arAssignSingle=$arData;}
    
    public function set_multiadd($arData){$this->arMultiAdd=$arData;}  
    /**
     * Con estos varlores se crean los campos hidden (por fila) con claves y descripciones que se pasaran a los destfields
     * @param array $arData array("destkey"=>"","destdesc"=>"","colkeys"=>",","coldescs"=>",");
     */
    public function set_singleadd($arData){$this->arSingleAdd=$arData;}
    /**
     * format: ("date","datetime4","datetime6","time4","time6","int","numeric2")
     * @param array $arFormat array("fieldname"=>"format"...)
     */
    public function set_format_columns($arFormat){$this->arConfigColTypes = $arFormat;}
    
    /**
     * @param array $arData array(0=>array("position"=>1,"label"=>"xxx","type"=>"anchor","href"=>"localhost/","hrefparams"=>array("col1","col2",)))
     */
    public function add_extra_colums($arData){$this->arExtraColumns = $arData;}

    /**
     * @param array $arColumns array("fieldname1","fieldname2"..)
     */
    public function set_column_hidden($arColumns){$this->arHiddenColumns = $arColumns;}
    
    /**
     * 
     * @param array $arColumns array("fieldname"=>"value","f.."=>"val2"..))
     */
    public function set_extra_hidden($arColumns){$this->arExtraHidden = $arColumns;}
    
    public function set_items_per_page($iItemsPerPage){$this->iItemsPerPage = $iItemsPerPage;}
    
    /**
     * Disable pagination controls
     * @param type $isOn
     */
    public function set_no_paginatebar($isOn=FALSE){$this->isPaginateBar=$isOn;}
    
    public function set_column_length($arColumnLength){$this->arColumnLength=[];if($arColumnLength)$this->arColumnLength=$arColumnLength;}
    public function add_column_length($sFieldName,$iLength){$this->arColumnLength[$sFieldName]=$iLength;}    
    //**********************************
    //             GETS
    //**********************************
    protected function get_tmpjs($cGlue="\n"){return implode($cGlue,$this->arTmpJs);}
    protected function has_column_length($sFieldName){$arFieldNames = array_keys($this->arColumnLength);return in_array($sFieldName,$arFieldNames);}
    protected function get_column_length($sFieldName){return $this->arColumnLength[$sFieldName];}
    
}