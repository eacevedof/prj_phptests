<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.2.2
 * @name HelperTextarea
 * @date 21-11-2016 22:24 (SPAIN)
 * @file helper_textarea.php
 * @observations
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperTextarea extends TheFrameworkHelper
{ 
    private $_cols;
    private $_rows;
    private $isCounterSpan;
    private $isCounterJs;
    
    public function __construct
    ($id="",$name="",$innerhtml="",$arExtras="",$maxlength=-1
    ,$cols=40,$rows=8,$class="",$style="",HelperLabel $oLabel=NULL)
    {
        $this->_type = "textarea";

        $this->_idprefix = "";
        $this->_id = $id;
        $this->_inner_html = $innerhtml;
        $this->_name = $name;
        $this->_cols = $cols;
        $this->_rows = $rows;

        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
       
        $this->_maxlength = $maxlength;
        $this->arExtras = $arExtras;
        $this->oLabel = $oLabel;
        
        $this->isCounterSpan = TRUE;
        $this->isCounterJs = TRUE;        
    }//__construct
    
    private function js_counter()
    {
?>

<script type="text/javascript" helper="textarea.js_counter">
    var fn_txaspan = function(oTextarea,sValue)
    {
        var sNameSpan = "sp"+oTextarea.id;
        var oSpan = document.getElementById(sNameSpan);
        if(oSpan)
            oSpan.innerHTML = sValue;
    };
    
    var fn_txamaxlength = function(oTextarea,oEvent)
    {
        var sInnerHtml = "";
        var isEvent = true;
        if(oTextarea)
        {
            var iMaxLen = oTextarea.getAttribute("maxlength") || 1000;
            sInnerHtml = oTextarea.value;
            var iLen = sInnerHtml.length;
            if(iLen>iMaxLen)
            {
                isEvent = false;
                iLen = iMaxLen;
                oTextarea.value = sInnerHtml;
            }
            var sLenText = iLen+"/"+iMaxLen;
            fn_txaspan(oTextarea,sLenText);
        }
        return isEvent;
    };
</script>    
<?php
    }//js_counter
    
    public function get_html()
    {  
        $sHtmlToReturn = "";
        if($this->oLabel) $sHtmlToReturn .= $this->oLabel->get_html();
        //Una longitud de 0 tiene un comportamiento parecido a un bloqueado
        if($this->_maxlength>-1)
            $this->_js_onkeyup .= " return fn_txamaxlength(this,event);";
        
        if($this->_comments) $sHtmlToReturn .= "<!-- $this->_comments -->\n";
        $sHtmlToReturn .= $this->get_opentag();
        $sHtmlToReturn .= htmlentities($this->_inner_html);
        $sHtmlToReturn .= $this->get_closetag();
        
        if($this->isCounterSpan)
            $sHtmlToReturn .= "\n<span id=\"sp$this->_idprefix$this->_id\"></span>"; 
        
        if($this->isCounterJs)
            $this->js_counter();
        
        return $sHtmlToReturn;
    }//get_html
    
    public function get_opentag()
    {
        $sHtmlOpenTag = "<$this->_type ";
        if($this->_id) $sHtmlOpenTag .= "id=\"$this->_idprefix$this->_id\" ";
        if($this->_name) $sHtmlOpenTag .= "name=\"$this->_idprefix$this->_name\" ";
        if($this->_rows) $sHtmlOpenTag .= "rows=\"$this->_rows\" ";
        if($this->_cols) $sHtmlOpenTag .= "cols=\"$this->_cols\" ";
        //propiedades html5
        if($this->_isDisabled) $sHtmlOpenTag .= "disabled ";
        if($this->_isReadOnly) $sHtmlOpenTag .= "readonly "; 
        if($this->_isRequired) $sHtmlOpenTag .= "required "; 
        //eventos
        if($this->_js_onfocus) $sHtmlOpenTag .= "onfocus=\"$this->_js_onfocus\" ";
        if($this->_js_onblur) $sHtmlOpenTag .= "onblur=\"$this->_js_onblur\" ";
        if($this->_js_onchange) $sHtmlOpenTag .= "onchange=\"$this->_js_onchange\" ";
        if($this->_js_onclick) $sHtmlOpenTag .= "onclick=\"$this->_js_onclick\" ";
        
        if($this->_js_onkeypress)
        {
            if($this->_isEnterInsert)
                $sHtmlOpenTag .= "onkeypress=\"$this->_js_onkeypress;onenter_insert(event);\" ";
            elseif($this->_isEnterUpdate)
                $sHtmlOpenTag .= "onkeypress=\"$this->_js_onkeypress;onenter_update(event);\" ";
            elseif($this->_isEnterSubmit)
                $sHtmlOpenTag .= "onkeypress=\"$this->_js_onkeypress;onenter_submit(event);\" ";
            $sHtmlOpenTag .= "onkeypress=\"$this->_js_onkeypress\" ";
        }
        
        if($this->_js_onkeydown) $sHtmlOpenTag .= "onkeydown=\"$this->_js_onkeydown\" ";
        if($this->_js_onkeyup) $sHtmlOpenTag .= "onkeyup=\"$this->_js_onkeyup\" ";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isEnterInsert) $sHtmlOpenTag .= "onkeypress=\"onenter_insert(event);\" ";
        elseif($this->_isEnterUpdate) $sHtmlOpenTag .= "onkeypress=\"onenter_update(event);\" ";
        elseif($this->_isEnterSubmit) $sHtmlOpenTag .= "onkeypress=\"onenter_submit(event);\" ";
        
        if($this->_js_onmouseover) $sHtmlOpenTag .= "onmouseover=\"$this->_js_onmouseover\" ";
        if($this->_js_onmouseout) $sHtmlOpenTag .= "onmouseout=\"$this->_js_onmouseout\" ";

        //aspecto
        $this->load_cssclass();
        if($this->_class) $sHtmlOpenTag .= "class=\"$this->_class\" ";
        $this->load_style();
        if($this->_style) $sHtmlOpenTag .= "style=\"$this->_style\" ";
        //atributos extras
        if($this->_maxlength) $sHtmlOpenTag .= "maxlength=\"$this->_maxlength\" ";
        if($this->arExtras) $sHtmlOpenTag .= " ".$this->get_extras();
        if($this->_isPrimaryKey) $sHtmlOpenTag .= "pk=\"pk\" ";
        if($this->_attr_dbtype) $sHtmlOpenTag .= "dbtype=\"$this->_attr_dbtype\" ";
        
        $sHtmlOpenTag .= ">\n";        
        return $sHtmlOpenTag;
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function set_maxlength($value){$this->_maxlength = $value;}
    public function set_rows($iValue){$this->_rows=$iValue;}
    public function set_cols($iValue){$this->_cols=$iValue;}
    public function set_counterspan($isOn=TRUE){$this->isCounterSpan = $isOn;}
    public function set_counterjs($isOn=TRUE){$this->isCounterJs = $isOn;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_maxlength(){return $this->_maxlength;}
    public function readonly($isReadOnly=TRUE){$this->_isReadOnly = $isReadOnly;}

}//HelperTextarea
