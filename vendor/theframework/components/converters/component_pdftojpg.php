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

use \Imagick;

class ComponentPdftojpg 
{
    private $arFrom;
    private $arTo;
    private $isError;
    private $arErrors;

    public function __construct() 
    {
        if(!extension_loaded("imagick")) throw new \Exception("imagick extension not found!");
        $this->isError = FALSE;
        $this->arErrors = array();
        //$this->arFrom = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
        //$this->arTo = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
    }

    private function _save($file, $blob)
    {
        //die("path:$file");
        //fwrite($file, base64_decode($blob));
        //fclose($file);
        $dec = base64_decode($blob);
        file_put_contents($file,$dec);
    }

    public function get()
    {
        $pathpdf = TFW_PATHTEMP."/example.pdf";
        $pathimg = TFW_PATHTEMP."/example.jpg";
        $imagick = new Imagick();
        
        //esta linea lanza la excepción: Fatal error: Uncaught ImagickException: PDFDelegateFailed `[ghostscript library 9.52] 
        // Read image from PDF
        $imagick->readImage($pathpdf);
        // Writes an image
        $imagick->writeImages($pathimg,false);
    }

    public function get3()
    {
        //error:  Fatal error: Uncaught ImagickException: no decode delegate for this image format `'
        $pdf = TFW_PATHTEMP."/example.pdf";
        $fp_pdf = fopen($pdf, 'rb');

        //imageick(0) me tira el servidor de desarrollo
        $img = new Imagick(); // [0] can be used to set page number
        $img->setResolution(300,300);
        $img->readImageFile($fp_pdf);
        $img->setImageFormat( "jpg" );
        $img->setImageCompression(Imagick::COMPRESSION_JPEG);
        $img->setImageCompressionQuality(90);

        $img->setImageUnits(Imagick::RESOLUTION_PIXELSPERINCH);
        //$img->writeImage(TFW_PATHTEMP."/img-1.jpg");
        $data = $img->getImageBlob();
        print_r($data);
    }

    public function get2()
    {
        //https://stackoverflow.com/questions/9227014/convert-pdf-to-jpeg-with-php-and-imagemagick
        $pathpdf = TFW_PATHTEMP."/example.pdf";
        $pathimg = TFW_PATHTEMP."/example.jpg";

        //esta linea lanza la excepción: PDFDelegateFailed `[ghostscript library 9.52] -sstdout=%stderr
        //no va con el constructor
        $Imagickpdf = new Imagick($pathpdf);
        $ipages = $Imagickpdf->getNumberImages();
        if($ipages) {
            for($i=0; $i<$ipages; $i++){
                $pathpage = $pathpdf."[$i]";
                $image = new Imagick($pathpage);
                $image->setImageFormat("jpg");
                $image->writeImage(TFW_PATHTEMP."/img-$i.jpg");
            }
        }
    }

    //no va ^^ no da error pero el archivo generado no se visualiza
    public function get1()
    {
        $pathpdf = TFW_PATHTEMP."/example.pdf";
        $pathimg = TFW_PATHTEMP."/example.jpg";
        $fp_pdf = fopen($pathpdf, 'rb');

        $img = new Imagick();
        $img->setResolution(300,300);
        $img->readImageFile($fp_pdf);
        $img->setImageFormat( "jpg" );
        $img->setImageCompression(Imagick::COMPRESSION_JPEG);
        $img->setImageCompressionQuality(90);

        $img->setImageUnits(Imagick::RESOLUTION_PIXELSPERINCH);
        $data = $img->getImageBlob();

        //$this->_save($pathimg, $data);
        header("Content-Type: image/jpg");
        echo $Imagick->getImageBlob();
    }

    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}

    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPdftojpg

//ghost
//usr/local/bin/gs
