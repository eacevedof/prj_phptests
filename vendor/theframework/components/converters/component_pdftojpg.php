<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentPdftojpg
 * @file component_pdftojpg.php
 * @version 1.0.0
 * @date 12-09-2020 09:51
 * @observations
 */
namespace TheFramework\Components\Converters;

class ComponentPdftojpg 
{
    private $arFrom;
    private $arTo;
    private $isError;
    private $arErrors;

    public function __construct() 
    {
        $this->isError = FALSE;
        $this->arErrors = array();
        //$this->arFrom = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
        //$this->arTo = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
    }

    private function _save($file, $blob)
    {
        fwrite($file, base64_decode($image));
        fclose($file);
    }

    public function get()
    {
        $pathpdf = TFW_PATHTEMP."/example.pdf";
        $pathimg = TFW_PATHTEMP."/example.jpg";
        $fp_pdf = fopen($pathpdf, 'rb');

        $img = new imagick();
        $img->setResolution(300,300);
        $img->readImageFile($fp_pdf);
        $img->setImageFormat( "jpg" );
        $img->setImageCompression(imagick::COMPRESSION_JPEG);
        $img->setImageCompressionQuality(90);

        $img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
        $data = $img->getImageBlob();

        $this->_save($pathimg,$blob);
    }

    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}

    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPdftojpg

