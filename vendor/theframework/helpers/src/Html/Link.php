<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name TheFramework\Helpers\Html\Link
 * @file Link.php
 * @date 13-05-2017 11:51 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\TheFrameworkHelper;

class Link extends TheFrameworkHelper
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
        $arHtml = array();
        foreach($this->arHrefs as $sHrefPath)
        {
            if($sHrefPath)
                $arHtml[] = "<link type=\"$this->sType\" rel=\"$this->sRel\" href=\"$sHrefPath\">\n";
        }
        return implode("",$arHtml);
    }//get_html
    
    public function show(){echo $this->get_html();}

    public function add_href($sFilePath){$this->arHrefs[] = $sFilePath;}
    public function set_hrefs($mxHref){$this->arHrefs = []; if(is_array($mxHref))$this->arHrefs=$mxHref; else $this->arHrefs[] = $mxHref;}
    
    public function get_hrefs(){return $this->arHrefs;}
    
}//HelperLink