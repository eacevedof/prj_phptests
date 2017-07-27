<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name HelperFpdfCell
 * @date 01-06-2014 12:45
 * @file helper_fpdf_cell.php
 * @observations
 *      requires: FPDF
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperFpdfCell extends TheFrameworkHelper
{
    protected $isSingle;//=FALSE;//single,multi
    
    //cell params
    protected $iWidth;
    protected $iHeigth;
    protected $sText;
    //protected $isTextUTF;
    protected $iBorder;
    protected $iNumNL;
    protected $cAlign;
    protected $isFill;
    protected $sUrlPageLink;
    
    //Localizacion
    protected $iX;
    protected $iY;
    
    //Estilos
    protected $iFontColor;
    protected $iFontSize;
    protected $sFontStyle;
    protected $iBackColor;
    protected $isResetColors;
    
    /**
     * Por defecto crea tipo multiline
     * @param boolean $isSingle
     */
    public function __construct($isSingle=FALSE)
    {
        //$this->Cell($iAncho,$iAltura,$sTitulo,$iAnchoBorde,$iSaltosLinea,$cAlineacion,fondo?TRUE|FALSE,??);
        //$w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''
        $this->isSingle = $isSingle;
        $this->iWidth = 1;
        $this->iHeigth = 1;
        $this->sText = "";
        $this->iBorder = 0;
        $this->iNumNL = 0;
        $this->isFill = FALSE;
        $this->sUrlPageLink = "";
        //$this->isTextUTF = TRUE;
        //MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
    }
    
    //==================================
    //             SETS
    //==================================
    public function set_y_byheight(){}

    public function set_single($isOn=TRUE){$this->isSingle = $isOn;}
    public function set_width($iValue){$this->iWidth = $iValue;}
    public function set_height($iValue){$this->iHeigth = $iValue;}
    public function set_text($sValue){$this->sText = $sValue;}
    public function set_border($iWidth){$this->iBorder = $iWidth;}
    public function set_numline_unit($iUnit){$this->iNumNL = $iUnit;}
    /**
     * Right, Center, Left, J??
     * @param char $cAlign R|C|J
     */
    public function set_type_align($cAlign){$this->cAlign = $cAlign;}
    public function set_usefill($isOn=TRUE){$this->isFill = $isOn;}
    public function set_pagelink($sValue){$this->sUrlPageLink = $sValue;}
    
    public function set_x($iX){$this->iX=$iX;}
    public function set_y($iY){$this->iY=$iY;}
    
    public function set_font($sValue){$this->sFont=$sValue;}
    /**
     * @param string $sValue B|IB|U
     */
    public function set_fontstyle($sValue){$this->sFontStyle=$sValue;}
    public function set_fontsize($iSize){$this->iFontSize=$iSize;}
    public function set_fontcolor($iValue){$this->iFontColor = $iValue;}
    public function set_backcolor($iValue){$this->iBackColor = $iValue;}
    public function set_resetcolors($isOn=TRUE){$this->isResetColors = $isOn;}
    //public function set_utf8($isOn=TRUE){$this->isTextUTF=$isOn;}
    
    //==================================
    //             GETS
    //==================================
    public function is_single(){return $this->isSingle;}
    public function get_width(){return $this->iWidth;}
    public function get_height(){return $this->iHeigth;}
    public function get_text()
    {
        return $this->sText;
    }
    
    public function get_border(){return $this->iBorder;}
    public function get_numline_unit(){return $this->iNumNL;}
    public function get_type_align(){return $this->cAlign;}
    public function get_usefill(){return $this->isFill;}
    public function get_pagelink(){return $this->sUrlPageLink;}
    
    public function get_x(){return $this->iX;}
    public function get_y(){return $this->iY;}
    
    public function get_font(){return $this->sFont;}
    public function get_fontstyle(){return $this->sFontStyle;}
    public function get_fontsize(){return $this->iFontSize;}
    public function get_fontcolor(){return $this->iFontColor;}
    public function get_backcolor(){return $this->iBackColor;}
    public function is_resetcolors(){return $this->isResetColors;}
    
}