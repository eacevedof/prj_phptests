<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentGd2
 * @file component_gd2.php
 * @version 1.0.0
 * @date 29-01-2018 11:48
 * @observations
 */
namespace TheFramework\Components;

class ComponentGd2 
{
    private $arFrom;
    private $arTmp;
    private $arTo;
    private $arErrors;
    
    //$GLOBALS["config_app_dir"].$GLOBALS["config_web_folder"].config_bar.$GLOBALS["config_res_dir"].config_bar."products_picture".config_bar.$Nom_Photo
    public function __construct() 
    {
        define("DS",config_bar);
        define("PATH_RESDIR", realpath($GLOBALS["config_app_dir"].$GLOBALS["config_web_folder"].DS.$GLOBALS["config_res_dir"]));
        
        $this->arErrors = array();
        $this->arFrom = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
        $this->arTmp = array();
        $this->arTo = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
    }
    
    private function get_type($sFilename){return end(explode(".",trim($sFilename)));}
    
    private function get_image_obj($sExtension,$sPathFile)
    {
        switch($sExtension) 
        {
            case "png": $oImage = imagecreatefrompng($sPathFile); break;
            case "gif": $oImage = imagecreatefromgif($sPathFile); break;
            case "bmp": $oImage = imagecreatefromwbmp($sPathFile); break;
            default:
                $oImage = imagecreatefromjpeg($sPathFile);
        }//switch(extension)
        return $oImage;
    }//get_image_obj
    
    private function get_image_blank_obj($iW,$iH)
    {
        $oImage = imagecreatetruecolor($iW,$iH);
        return $oImage;
    }//get_image_blank_obj
    
    private function save_in_blank($arFrom,$arTo)
    {
        
        //imagecopyresampled($dst_image, $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $dst_w, int $dst_h, int $src_w, int $src_h): bool {}
        //imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        //imagecopyresampled($tnImage,$fullImage, 0,$isy, 0,0, $ix,$iy, $fullSize[0],$fullSize[1]);
        return imagecopyresampled($arTo["path"],$arFrom["path"]
            ,$arTo["x"],$arTo["y"],$arFrom["x"],$arFrom["y"]
            ,$arTo["w"],$arTo["h"], $arFrom["w"],$arFrom["h"]);
    }//save_in_blank
    
    public function get_size($sPathFile)
    {
        //getimagesize("https://www.virginexperiencedays.co.uk/content/img/product/large/big-cat-encounter--17120907.jpg");
        /*array(7) {
        [0]=>
        int(1200)
        [1]=>
        int(800)
        [2]=>
        int(2)
        [3]=>
        string(25) "width="1200" height="800""
        ["bits"]=>
        int(8)
        ["channels"]=>
        int(3)
        ["mime"]=>
        string(10) "image/jpeg"
        }*/
        $arSize = getimagesize($sPathFile);
        return array("with"=>$arSize[0],"height"=>$arSize[1]);
    }//get_size
    
    public function resize($arTo)
    {
        $iW = $arTo["w"];
        $iH = $arTo["h"];
        $this->arFrom["pathfile"] = $this->arFrom["pathfolder"].$this->arFrom["filename"];
        $this->arTo["pathfile"] = $this->arFrom["pathfolder"].$this->arFrom["filename"];
        
        if(!is_file($this->arFrom["pathfile"]))
            $this->arErrors[] = "Archivo no encontrado";
        
        if($iW)
        {
            
        }
        elseif($iH)
        {
            
        }
        else
        {
            echo "sin datos!!";
        }
        
    }//resize
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    
    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}
    
    public function is_error(){return $this->isError;}
}//class ComponentGd2