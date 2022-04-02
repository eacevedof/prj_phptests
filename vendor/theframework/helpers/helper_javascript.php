<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.8.1
 * @name HelperJavascript
 * @file helper_javascript.php
 * @date 06-02-2017 13:59 (SPAIN)
 * @observations core library
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperJavascript extends TheFrameworkHelper
{
    protected $sSubpathPlugin;
    protected $sSubpathJs;
    protected $sSubpathExt;
    protected $sSaveAction;
    protected $sFocusId;
    protected $arFilters;
    protected $sFormId;
    
    protected $arPathfiles = array("type"=>"custom|jquery","filename");
    protected $arJsLines = array();
    
    protected $arValidate = array();
    protected $arTmpJs;
    protected $arMultiForm = [];
    
    public function __construct($sSubPathExt="", $arSubPathFiles=array())
    {
        $this->arPathfiles = $arSubPathFiles;
        if(defined("TFW_SUBPATH_JSDS")) $this->sSubpathJs = TFW_SUBPATH_JSDS;//@check
        if(defined("TFW_SUBPATH_PLUGINDS")) $this->sSubpathPlugin = TFW_SUBPATH_PLUGINDS;//@check
        $this->sSubpathExt = $sSubPathExt;
        $this->sFormId = "frmList";
        //esto se escribe en hidAction y despues se comprueba con ->is_updating o ->is_inserting
        $this->sSaveAction = "insert";//insertlist,update,updatelist
        $this->sFocusId = "frmList";
    }
    
    private function add_filesrc($sFileName,$sType,$sPath)
    {
        if(!strpos($sFileName,".js")) $sFileName .= ".js";
        if(!empty($sType)) $sPath .= "$sType/";
        $sPath .= $sFileName;
        if(!in_array($sPath, $this->arPathfiles))
            $this->arPathfiles[] = $sPath; 
    }
    
    private function html_lines_between_tags()
    {
        $sLines = "";
        foreach($this->arJsLines as $sLine)
            $sLines .= $sLine ."\n";
        return $sLines;
    }
    
    /**
     * Devuelve inner_html si existiera unido a las lineas añadidas 
     * al array de lineas con add_js_line() formando todos es to "any content"
     * @return string tipo <script..>...any content ...</script>
     */
    public function get_html()
    {
        $sJs = $this->get_opentag();
        if($this->_inner_html) $sJs.=$this->_inner_html;
        $sJs .= $this->html_lines_between_tags();
        $sJs .= $this->get_closetag();
        return $sJs;
    }
    
    public function show_tag_links(){echo $this->get_html_tag_links();}
    
    public function add_multiform($sFormId,$sSaveAction="insert"){$this->arMultiForm[]=["formid"=>$sFormId,"saveaction"=>$sSaveAction];}
    
    //**********************************
    //             SETS
    //**********************************
    public function add_tfw_filesrc($sFileName,$sType="custom"){$this->add_filesrc($sFileName,$sType,$this->sSubpathJs);}
    //public function set_path_files($arPaths){$this->arPathfiles = $arPaths;}
    public function add_js_line($sScriptLine){$this->arJsLines[] = $sScriptLine;}
    public function add_path_file($sFilePath){$this->arPathfiles[] = $sFilePath;}
    public function add_plug_filesrc($sFolderName,$sFileName)
    {
        $sPath = $this->sSubpathPlugin.$sFolderName."/js/";
        $this->add_filesrc($sFileName,null,$sPath); 
    }
    
    public function add_ext_filesrc($sFileName,$sSubPath="")
    {
         if(empty($this->sSubpathExt))
            if(empty($sSubPath))$sSubPath = "js/";
        else
            $sSubPath = $this->sSubpathExt;
        $this->add_filesrc($sFileName,null,$sSubPath);
    }
    
    public function set_validate_config($arValidate){$this->arValidate=$arValidate;}
    public function set_updateaction($sAction="update"){$this->sSaveAction=$sAction;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_opentag($attrib=""){return "<script type=\"text/javascript\"$attrib>\n";}
    public function get_closetag(){return "</script>\n";}
    
    /**
     * devuelve un tag script con atributo src
     * @param string $sSrcPath
     * @return string <script type=\"text/javascript\" src=\"$sSrcPath\"></script>
     */
    private function get_html_tag_script_link($sSrcPath)
    {
        $sScriptTag = "";
        if($sSrcPath) $sScriptTag = "<script type=\"text/javascript\" src=\"$sSrcPath\"></script>\n";
        return $sScriptTag;
    }
    
    /**
     * Para poder cargar estos scripts se debe de añadir las rutas con addfile
     * Devuelve varios tags de tipo script src
     * @return string de tipo <script src=...></script> <script ...></script>
     */
    public function get_html_tag_links()
    {
        $sLinks = "";
        foreach($this->arPathfiles as $sSrcPath)
            $sLinks .= $this->get_html_tag_script_link($sSrcPath);
        return $sLinks;
    }
    
    public function fn_save()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_save\"");
        $sJs .= "
        //sMessage: Confirm message
        //sUrl: send form url
        function $this->sSaveAction(sMessage,sUrl)
        {
            var sFormId = \"$this->sFormId\";
            var oForm = document.getElementById(sFormId);
            if(oForm)
            {
                var objError = {};
                objError.message = \"\";
                
                if(window.arObjFields!==undefined)
                    if(TfwFieldValidate && arObjFields!=null)
                        objError = TfwFieldValidate.checkfields(arObjFields);

                if(objError.message==\"\")
                {
                    var isConfirmed = true;
                    if(sMessage)
                        isConfirmed = confirm(sMessage);
                    
                    if(isConfirmed)
                    {
                        var oHidAction = document.getElementById(\"hidAction\");
                        if(oHidAction)oHidAction.value=\"$this->sSaveAction\";
                        if(sUrl) oForm.action = sUrl;
                        oForm.submit();
                        return true;
                    }
                }
                else
                {
                    alert(objError.message);
                }
            }
            return false;
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }    
    
    public function fn_parentform()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_parentform\"");
        $sJs .= "
        var get_parentform = function(oElem)
        { 
            if(oElem.form!==undefined)
                return oElem.form;
            return null;
        };
        ";
        $sJs .= $this->get_closetag();
        return $sJs;             
    }

    public function fn_setvallike()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_setvallike\"");
        $sJs .= "
        var set_vallike = function(oForm,sIdLike,sValue)
        { 
            var arElem = oForm.elements;
            if(arElem)
            {
                var oTmp = null;
                for(var i=0; i<arElem.length; i++)
                {
                    oTmp = arElem[i];
                    if(oTmp.id != undefined)
                    {
                        var sId = oTmp.id;
                        if(sId.indexOf(sIdLike)!=-1)
                        {
                            oTmp.value = sValue;
                        }
                    }
                }
            }//if arElem
        };
        ";
        $sJs .= $this->get_closetag();
        return $sJs;             
    }

    public function fn_savemulti()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_savemulti\"");
        $arActions = [];
        foreach($this->arMultiForm as $arConfig)
            $arActions[] = $arConfig["saveaction"];
        
        $arActions = array_unique($arActions);
        foreach($arActions as $sAction)
            $sJs .= "
            function {$sAction}multi(eClicked,sMessage,sUrl)
            {
                var oForm = get_parentform(eClicked);

                if(oForm)
                {
                    var objError = {};
                    objError.message = \"\";

                    if(window.arObjFields!==undefined)
                        if(TfwFieldValidate && arObjFields!=null)
                            objError = TfwFieldValidate.checkfieldsform(arObjFields,oForm);

                    if(objError.message==\"\")
                    {
                        var isConfirmed = true;
                        if(sMessage)
                            isConfirmed = confirm(sMessage);

                        if(isConfirmed)
                        {
                            set_vallike(oForm,\"hidAction\",\"$sAction\");

                            var sIdName = \"\";
                            if(oForm.id != undefined) sIdName=oForm.id;
                            if(sIdName==\"\" && oForm.name!=undefined) sIdName=oForm.name;
                            set_vallike(oForm,\"hidForm\",sIdName);

                            if(sUrl)oForm.action = sUrl;
                            oForm.submit();
                            return true;
                        }
                    }
                    else
                    {
                        alert(objError.message);
                    }
                }
                return false;
            }//{$sAction}multi
            ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }    
    
    public function check_before_save($arValidate=array())
    {
        if(!$arValidate)
            $arValidate = $this->arValidate;
        //bug($arValidate,"check_before_save");
        //$arFieldsConfig["first_name"] = array("label"=>tr_first_name,"length"=>100,"type"=>array("required"),"id"=>"");
        //var oTmpField = null;//TfwField(sId,iLen,sLabel,arValidate)
        //consturir esto: arObjFields
        //TfwFieldValidate.checkfields($arFieldsConfig);
        $arJsObj = array();
        $arJsObj[] = "var arObjFields = [];";
        if($this->arMultiForm)
            foreach($this->arMultiForm as $arConfig)
            {
                $sFormId = $arConfig["formid"];
                if(isset($arValidate[$sFormId]))
                    $arRules = $arValidate[$sFormId];
                //bug($arRules,"formid:$sFormId");
                foreach($arRules as $arData)
                {
                    $sControlId = "";
                    if(isset($arData["id"])) $sControlId = $arData["id"];
                    if(!$sControlId) $sControlId = $arData["controlid"];
                    $iLen = $arData["length"];
                    $sLabel = $arData["label"];
                    //arObjFields.push(new TfwField('',100,'Last Name',[''required'']));
                    //si se ha definido una longitud se valida por este dato
                    if($iLen) $arData["type"][]="length";
                    $sArValidate = $this->get_string_array($arData["type"]);
                    $sJsObj = "new TfwField('$sControlId',$iLen,'$sLabel',$sArValidate,'$sFormId')";
                    $arJsObj[] = "arObjFields.push($sJsObj);";
                }
            }
        else
            foreach($arValidate as $arData)
            {
                //pr("no multi");
                $sControlId = "";
                if(isset($arData["id"])) $sControlId = $arData["id"];
                if(!$sControlId) $sControlId = $arData["controlid"];
                $iLen = $arData["length"];
                $sLabel = $arData["label"];
                //arObjFields.push(new TfwField('',100,'Last Name',[''required'']));
                //si se ha definido una longitud se valida por este dato
                $sFormId = "";
                if($iLen) $arData["type"][]="length";
                $sArValidate = $this->get_string_array($arData["type"]);
                $sJsObj = "new TfwField('$sControlId',$iLen,'$sLabel',$sArValidate,'$sFormId')";
                $arJsObj[] = "arObjFields.push($sJsObj);";
            }
        
        $sJs = $this->get_opentag(" helper=\"javascript.check_before_save\"");
        $sJs .= implode("\n",$arJsObj);
        $sJs .= $this->get_closetag();
        $sJs .= $this->fn_save();
        $sJs .= $this->fn_parentform();
        $sJs .= $this->fn_setvallike();
        $sJs .= $this->fn_savemulti();
        return $sJs;
    }//check_before_save
    
    public function get_string_array($arValues)
    {
        $arVals = array();
        $isArray = FALSE;
        foreach($arValues as $sValue)
        {
            if(is_array($sValue)) 
            {    
                $sValue = $this->get_string_array($sValue);
                $isArray=true;
            }
            else
                $sValue = str_replace("'","\'",$sValue);
            $arVals[] = $sValue;
        }
        
        if($isArray) return "[".implode(",",$arVals)."]";
        return "['".implode("','",$arVals)."']";
    }
    
    protected function convert_to_urlparams($arForParams)
    {
        $arUrl = array();
        foreach($arForParams as $arParams)
            foreach($arParams as $sFieldName=>$sValue)
                $arUrl[] = "$sFieldName=$sValue";
        return implode("&",$arUrl);
    }
    
    public function array_to_json($array)
    {
        //bug($array,"array");
        //'{"result":true,"count":1}',
        $arPairs = array();
        foreach($array as $key=>$mxValue)
        { 
            if(is_array($mxValue))
            {
                $mxValue = $this->array_to_json($mxValue);
                $arPairs[] = "\"$key\":$mxValue";
            }else
                $arPairs[] = "\"$key\":\"$mxValue\"";
        }
        $sJson = implode(",",$arPairs);
        $sJson = "{".$sJson."}";
        //bug($sJson);
        return $sJson;
    }

    public function fn_multiassign_window()
    {
        $this->set_tmpjs();
        
        if($this->isPermaLink)
        {
            //@@TODO
            $this->add_tmpjs("window.open(\"/\"+sUrlAction,\"multiassign\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=1,resizable=0,left=0,top=0);");
        }
        else
        {
            $this->add_tmpjs("window.open(sUrlAction,\"multiassign\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=1,resizable=0,left=0,top=0);");
        }
        
        $sTmpJs = $this->get_tmpjs();        
        
        $sJs = $this->get_opentag(" helper=\"javascript.fn_multiassign_window\"");
        $sJs .= "

        function multiassign_window(sUrlAction,iW,iH)
        {
            var iW = iW||800;
            var iH = iH||600;
            var sUrlAction = sUrlAction || window.location.search;
            $sTmpJs
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;
    }

    public function fn_singleassign_window()
    {
        $this->set_tmpjs();
        
        if($this->isPermaLink)
        {
            $this->add_tmpjs("window.open(\"/\"+sUrlAction,\"multiassign\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");
        }
        else
        {
            $this->add_tmpjs("window.open(sUrlAction,\"multiassign\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");
        }
        
        $sTmpJs = $this->get_tmpjs();  
        
        $sJs = $this->get_opentag(" helper=\"javascript.fn_singleassign_window\"");
        $sJs .= "
        function singleassign_window(sUrlAction,iW,iH)
        {
            var iW = iW||800;
            var iH = iH||600;
            var sUrlAction = sUrlAction || window.location.search;
            $sTmpJs
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;
    }
    
    public function fn_singleadd()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_singleadd\"");
        $sJs .= "
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
        $sJs .= $this->get_closetag();
        return $sJs;        
    }
    
    protected function build_js_field_ids()
    {
        $arIds = array_values($this->arFilters);
        $sFieldIds = implode("\",\"",$arIds);
        $sFieldIds = "\"$sFieldIds\"";
        return $sFieldIds;
    }    
    
    public function fn_postback()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_postback\"");
        $sJs .= "
        function postback(oControl)
        {
            var oForm = oControl.form;
            if(oForm) 
            {
                var sIdName = \"\";
                if(oForm.id != undefined) sIdName=oForm.id;
                if(sIdName==\"\" && oForm.name!=undefined) sIdName=oForm.name;
                set_vallike(oForm,\"hidForm\",sIdName);
                set_vallike(oForm,\"hidAction\",\"postback\");
                set_vallike(oForm,\"hidPostback\",oControl.id);
                
                oForm.action = window.location;
                oForm.submit();
            }
            else
                bug(\"form not found - fn_postback\");
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }
    
    public function fn_resetfilters()
    {
        $sFieldIds = $this->build_js_field_ids();
        $sJs = $this->get_opentag(" helper=\"javascript.fn_resetfilters\"");
        $sJs .= "
        function reset_filters()
        {
            var arFields = [$sFieldIds];
            TfwFieldValidate.reset(arFields);
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    } 
    
    public function fn_multiadd()
    {
        $this->set_tmpjs();

        $sJs = $this->get_opentag(" helper=\"javascript.fn_multiadd\"");
        $sJs .= "
        function multiadd(sUrlAction,sIdForm)
        {
            var sIdForm = sIdForm || \"$this->sFormId\"; 
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
        $sJs .= $this->get_closetag();
        return $sJs;        
    }    

    public function fn_onenter_insert()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_onenter_insert\"");
        $sJs .= "
        function onenter_insert(oEvent)
        {
            var iKeyPressed = 0;
            //var event = this.event;
            if(window.event) iKeyPressed = window.event.keyCode;
            else if(oEvent) iKeyPressed = oEvent.which;
            else return true;

            if(iKeyPressed == 13)
            {
                insert(); 
                return false;
            }
            else
               return true;
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }

    public function fn_onenter_update()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_onenter_update\"");
        $sJs .= "
        function onenter_update(oEvent)
        {
            var iKeyPressed = 0;
            //var event = this.event;
            if(window.event) iKeyPressed = window.event.keyCode;
            else if(oEvent) iKeyPressed = oEvent.which;
            else return true;

            if(iKeyPressed == 13)
            {
                update(); 
                return false;
            }
            else
               return true;
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }
    
    public function fn_onenter_submit()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_onenter_submit\"");
        $sJs .= "
        function onenter_submit(oEvent)
        {
            var sFormId = \"$this->sFormId\";
            var iKeyPressed = 0;
            //var event = this.event;
            if(window.event) iKeyPressed = window.event.keyCode;
            else if(oEvent) iKeyPressed = oEvent.which;
            else return TRUE;

            if(iKeyPressed == 13)
            {
                var sUrl = window.location;
                var oForm = document.getElementById(sFormId);
                var oHidAction = document.getElementById('hidAction');
                if(oForm) 
                {
                    if(oHidAction) oHidAction.value = 'enter_submit';
                    oForm.action = sUrl;
                    oForm.submit();
                }
                else
                    bug('form id not defined - fn_onenter_submit');
             }
        }
        ";
        $sJs .= $this->get_closetag();
        return $sJs;        
    }
        
    public function fn_closeme()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.fn_closeme\"");
        $sJs .= "function closeme(){self.close();}";
        $sJs .= $this->get_closetag();
        return $sJs;
    }    
    
    public function script_botchecker()
    {
?>
<script src="/js/the_framework/tfw/helpers/helper_form.js" helper="javascript.script_botchecker" type="text/javascript"></script>
<script src="/js/the_framework/tfw/helpers/helper_input_hidden.js" helper="javascript.script_botchecker" type="text/javascript"></script>
<script src="/js/the_framework/tfw/helpers/helper_input_text.js" helper="javascript.script_botchecker" type="text/javascript"></script>
<script src="/js/the_framework/tfw/helpers/helper_label.js" helper="javascript.script_botchecker" type="text/javascript"></script>
<script src="/js/the_framework/classes/js_botchecker.js" helper="javascript.script_botchecker" type="text/javascript"></script>
<script type="text/javascript" helper="javascript.script_botchecker">
    var eCount = document.getElementById("spAfter");
    var oForm = new HelperForm("frmComment");
    
    oInput = new HelperInputText("txtBot");
    oInput.set_type("number");
    //oInput.set_value("soy botero");
    oInput = oInput.get_element();
    oForm.add_field(oInput,eCount);
    
    oInput = new HelperLabel("lblBot","txtBot");
    oInput.add_attribute("class","control-label");
    oInput.set_innerhtml("-");
    oInput = oInput.get_element();
    oForm.add_field(oInput,eCount);
    
    var oInput = new HelperInputHidden("hidBot");
    oInput.set_value(":)");
    oInput = oInput.get_element();
 
    var oBot = new Botchecker();
    oBot.set_label("lblBot");
    oBot.set_txt("txtBot");
    oBot.set_hidden("hidBot");
    oBot.randomize();
    
    var fnOnsubmit = function()
    {
        var isEmail = function(sEmail)
        {
            var sPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return sPattern.test(sEmail);
        }

        var oTxt = document.getElementById("txtEmail");
        if(!isEmail(oTxt.value))
        {
            var sMessage = get_valmessage("valemail","fieldname","Email");
            alert(sMessage);
            oTxt.focus();
            return false;
        }
        
        var oError = TfwFieldValidate.checkfields(arObjFields);
        if(oError.message==="")
        {
            if(oBot.check())
            {
                oTxt = document.getElementById("hidAction");
                oTxt.value = "insert";
                return true;
            }
            else
            {
                oTxt = document.getElementById("txtBot");
                oTxt.value="";
                oTxt.focus();
            }
        }
        else
            alert(oError.message);
        return false;
    }//fnOnsubmit
    
    oForm.on_submit(fnOnsubmit);
</script>
<?php
    }//script_botchecker
    
    public function show_tr()
    {
        $sLang = $this->get_get("tfw_iso_language");
        $sPathTr = TFW_PATH_FOL_THEAPPLICATIONDS."translations/$sLang/translate_validate.php";
        $sTr = file_get_contents($sPathTr);
        $sTr = trim($sTr);
        $iFdef = strpos($sTr,"define(");
        $sTr = substr($sTr,$iFdef);
        $sTr = str_replace("define(\"tr_js_","",$sTr);
        //$sTr = trim($sTr);
        $arLines = explode("\");",$sTr);
        $arTr = [];
        foreach($arLines as $sLine)
        {
            $arTmp = explode("\",\"",$sLine);
            if($arTmp[0])
                //bug($arTmp);
                $arTr[trim($arTmp[0])] = trim($arTmp[1]);
        }
        //bug($arTr);
        if($arTr)
        {
            $arJs = [];
            $arJs[] = $this->get_opentag(" helper=\"javascript.show_tr\"");
            $arJs[] = "var oTfwtr = {};";
            foreach($arTr as $sTr=>$sStr)
            {
                $sTmp = "oTfwtr.$sTr = \"$sStr\";";
                $arJs[] = $sTmp;
            }
            $arJs[] = "function get_valmessage(sType,sTag,sRep)
            {
                var sMessage = \"\";
                if(oTfwtr[sType]!==undefined)
                {
                    sMessage = oTfwtr[sType];
                    if(sTag && sRep)
                        sMessage = sMessage.replace(\"%%\"+sTag+\"%%\",sRep);
                }
                return sMessage;
            }";
            //$arJs[] = "console.log(oJstr);alert(oJstr.vallength);";
            $arJs[] = $this->get_closetag();
            s(implode("\n",$arJs));
        }
    }//show_tr
    
    public function set_focusid($value){$this->sFocusId = $value;}
    public function set_filters($arFields){$this->arFilters=$arFields;}
    public function set_formid($value){$this->sFormId = $value;}
    
    public function process_focus()
    {
        $sJs = $this->get_opentag(" helper=\"javascript.process_focus\"");
        $sJs .= 
        "   var oElement = document.getElementById(\"$this->sFocusId\");
            if(!oElement) oElement = document.getElementsByName(\"$this->sFocusId\")[0];
            if(oElement && (oElement.focus!=undefined)) oElement.focus();
        ";
        $sJs .= $this->get_closetag();
        return $sJs;
    }
    
    protected function set_tmpjs($mxValues=NULL)
    {
        $this->arTmpJs=array();
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
    
    protected function get_tmpjs($cGlue="\n"){return implode($cGlue,$this->arTmpJs);}
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){echo $this->get_opentag();}
    public function show_closetag(){echo $this->get_closetag();}
    public function show_fn_multiassign(){echo $this->fn_multiassign_window();}
    public function show_fn_singleassign_window(){echo $this->fn_singleassign_window();}
    public function show_fn_multiadd(){echo $this->fn_multiadd();}
    public function show_fn_singleadd(){echo $this->fn_singleadd();}
    public function show_fn_closeme(){echo $this->fn_closeme();}
    public function show_fn_resetfilters(){echo $this->fn_resetfilters();}
    public function show_fn_setfocus(){echo $this->process_focus();}
    public function show_fn_save(){echo $this->fn_save();}
    public function show_check_before_save($arValidate=array()){echo $this->check_before_save($arValidate);}
    public function show_fn_postback(){echo $this->fn_postback();}
    public function show_fn_parentform(){echo $this->fn_parentform();}
    public function show_fn_setvallike(){echo $this->fn_setvallike();}
    public function show_fn_enterinsert(){echo $this->fn_onenter_insert();}
    public function show_fn_enterupdate(){echo $this->fn_onenter_update();}
    public function show_fn_entersubmit(){echo $this->fn_onenter_submit();}
 
}//HelperJavascript