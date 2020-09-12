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

    public function get()
    {
        die(__DIR__);
        //$pathpdf =
        $pdf_file = escapeshellarg( "mysafepdf.pdf" );
        $jpg_file = escapeshellarg( "output.jpg" );

        $result = 0;
        exec( "convert -density 300 {$pdf_file} {$jpg_file}", null, $result );
    }

    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}

    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPdftojpg

