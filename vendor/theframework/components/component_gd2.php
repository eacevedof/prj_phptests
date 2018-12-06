<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentGd2
 * @file component_gd2.php
 * @version 1.1.0
 * @date 31-03-2018 17:41
 * @observations
 */
namespace TheFramework\Components;

class ComponentGd2 
{
    private $arFrom;
    private $arTo;
    private $isError;
    private $arErrors;
    
    //$GLOBALS["config_app_dir"].$GLOBALS["config_web_folder"].config_bar.$GLOBALS["config_res_dir"].config_bar."products_picture".config_bar.$Nom_Photo
    public function __construct() 
    {
        if(!defined("DS"))define("DS",defined("config_bar")?config_bar:DIRECTORY_SEPARATOR);  
        $this->define_resdir();
        $this->isError = FALSE;
        $this->arErrors = array();
        $this->arFrom = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
        $this->arTmp = array();
        $this->arTo = array("pathfolder"=>PATH_RESDIR.DS."products_picture".DS,"filename"=>"");
    }
    
    private function define_resdir()
    {
        if(!defined("PATH_RESDIR"))
            define("PATH_RESDIR",realpath($GLOBALS["config_app_dir"].$GLOBALS["config_web_folder"].DS.$GLOBALS["config_res_dir"]));        
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
    
    /**
     * a partir de dos objetos, uno en blanco (lienzo) y otro original ($arFrom[object]) se copia el original en el blanco
     * @param array $arFrom array("object","x","y","w","h")
     * @param array $arTo array("object","x","y","w","h")
     * @return boolean
     */
    private function save_in_blank($arFrom,$arTo)
    {
        //imagecopyresampled($dst_image, $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $dst_w, int $dst_h, int $src_w, int $src_h): bool {}
        //imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        //imagecopyresampled($tnImage,$fullImage, 0,$isy, 0,0, $ix,$iy, $fullSize[0],$fullSize[1]);
        return imagecopyresampled($arTo["object"],$arFrom["object"]
            ,$arTo["x"],$arTo["y"],$arFrom["x"],$arFrom["y"]
            ,$arTo["w"],$arTo["h"], $arFrom["w"],$arFrom["h"]);
    }//save_in_blank
    
    public function get_size($sPathFile)
    {
        //getimagesize("https://www.virginexperiencedays.co.uk/content/img/product/large/big-cat-encounter--17120907.jpg");
        /*array(7) {[0]=>int(1200) [1]=> int(800) [2]=> int(2) [3]=> string(25) "width="1200" height="800"" ["bits"]=> int(8)
        ["channels"]=>int(3) ["mime"]=> string(10) "image/jpeg"}*/
        $arSize = getimagesize($sPathFile);
        return array("w"=>$arSize[0],"h"=>$arSize[1]);
    }//get_size
    
    /**
     * w: El ancho en el que se desea transformar la imagen original
     * h: La altura que tendrá la imagen original. 
     * Son excluyentes, en caso de pasar los dos valores se tomara unicamente w
     * @param array $arTo array("w","h")
     */
    public function resize($arTo)
    {
        $iW = isset($arTo["w"])?$arTo["w"]:NULL;
        $iH = isset($arTo["h"])?$arTo["h"]:NULL;
        $this->arFrom["pathfile"] = $this->arFrom["pathfolder"].DS.$this->arFrom["filename"];
        $this->arTo["pathfile"] = $this->arFrom["pathfolder"].DS.$this->arFrom["filename"];
        
        $sPathFileFrom = $this->arFrom["pathfile"];
        if(!$sPathFileFrom) $this->add_error ("Ruta de origen no proporcionada");
        if(!$this->arTo["pathfile"]) $this->add_error ("Ruta de destino no proporcionada");
        if(!is_file($sPathFileFrom)) $this->add_error("Archivo no encontrado en $sPathFileFrom");
        
        if(($iW || $iH) && !$this->isError)
        {
            $sExt = $this->get_type($this->arFrom["filename"]);
            $oImgFrom = $this->get_image_obj($sExt,$sPathFileFrom);
            $arSize = $this->get_size($sPathFileFrom);

            if($iW)
            {
                $iH = floor($arSize["h"]/$arSize["w"]*$iW);                
            }
            elseif($iH)
            {
                $iW = floor($arSize["h"]/$arSize["w"]*$iH);
            }
            
            $oImgBlank = $this->get_image_blank_obj($iW,$iH);
            $arFrom = array("object"=>$oImgFrom,"x"=>0,"y"=>0,"w"=>$arSize["w"],"h"=>$arSize["h"]);
            $arTo = array("object"=>$oImgBlank,"x"=>0,"y"=>0,"w"=>$iW,"h"=>$iH);
            //se guarda en el lienzo en blanco
            $isPrinted = $this->save_in_blank($arFrom,$arTo);
            if($isPrinted)
            {
                imagejpeg($arTo["object"],$this->arTo["pathfile"]);
                imagedestroy($oImgFrom);
                imagedestroy($oImgBlank);
            }
            else
            {
                $this->add_error("Ocurrio un error al guardar en blanco: arFrom:".var_export($arFrom,1)." arTo:".var_export($arTo,1));
            }            
        }
        else
        {
            $this->add_error("No hay datos de destino:".var_export($arTo,1));
        }
        
    }//resize
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentGd2

