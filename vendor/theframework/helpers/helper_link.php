<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name HelperLink
 * @file helper_css.php
 * @date 13-05-2017 11:51 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;

class HelperLink extends TheFrameworkHelper
{
    private $sType;//media_type	Specifies the media type of the linked document
    private $sRel;//alternate,author,dns-prefetch,help,icon,license,next,pingback
                  //,preconnect,prefetch,preload,prerender,prev,search,stylesheet
    private $arHrefs;
    
    public function __construct($arHrefs=[],$type="text/css",$rel="stylesheet")
    {
        $this->sType = $type;
        $this->sRel = $rel;
        $this->arHrefs = $arHrefs;
    }
    
    public function get_html()
    {
        $sHtmlToReturn = "";
        foreach($this->arHrefs as $sHrefPath)
        {
            if($sHrefPath)
                $sHtmlToReturn .= "<link type=\"$this->sType\" rel=\"$this->sRel\" href=\"$sHrefPath\">\n";
        }
        return $sHtmlToReturn;
    }//get_html
    
    public function show(){echo $this->get_html();}

    public function add_href($sFilePath){$this->arHrefs[] = $sFilePath;}
    public function set_hrefs($mxHref){$this->arHrefs = []; if(is_array($mxHref))$this->arHrefs=$mxHref; else $this->arHrefs[] = $mxHref;}
    
    public function get_hrefs(){return $this->arHrefs;}
    
}//HelperLink