<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentGetter
 * @file component_getter.php
 * @version 1.1.0
 * @date 01-06-2014 12:45
 * @observations
 */
namespace TheFramework\Components;

class ComponentGetter 
{
    public function __construct() 
    {
        
    }
    
    //https://stackoverflow.com/questions/724391/saving-image-from-php-url    
    public function save_image($inPath,$outPath)
    { 
        //Download images from remote server
        $in = fopen($inPath, "rb");
        $out = fopen($outPath, "wb");

        while($chunk = fread($in,8192))
            fwrite($out,$chunk, 8192);

        fclose($in);
        fclose($out);
    }    
    
    public function download()
    {
        $arUrls = [
            "https://feminismandreligion.files.wordpress.com/2015/05/walk-in-closet.jpg"
            //"http://www.bestours.es/viajes-de-empresa/wp-content/uploads/2016/08/Personal-shopper-nh-collection.jpg",
            //"http://wavemagazine.ca/wp-content/uploads/2014/08/vestir-para-o-sucesso-2.jpg",
            //"http://www.bliqx.net/wp-content/uploads/2013/08/women-spend-more-money-when-shopping-together.jpg",
            //"http://www.altacosturaonline.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/b/o/bono_regalo_white_2_1.png",
            //"https://trello-attachments.s3.amazonaws.com/56daeb36d2c864a40e356154/59be94d10d1afca1022534d4/e441828eaa3fa87561cf674220288a02/IMG-20170917-WA0001.jpg",
        ];
        $sPathDest = "D:\\temp\\";
        foreach($arUrls as $i=>$sUriImage)
        {
            $sFileName = basename($sUriImage); // to get file name
            $this->debug($sFileName);
            //$this->debug(parse_url($sUriImage));
            $this->save_image($sUriImage,$sPathDest.$sFileName);
        }
    }
    
    public function go()
    {
        echo "ComponentGetter.go :)";
    }
    
    public function debug($mxVar){echo var_export($mxVar,1)."\n";}  
}//ComponentGetter