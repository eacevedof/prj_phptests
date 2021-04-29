<?php
namespace Ipblocker\Services\Rulez;
use Ipblocker\Rulez;

use Ipblocker\Components\StringComponent;
use Ipblocker\Components\ArrayComponent;

class UrlService implements IRulez
{
    private string $requrl;
    private array $arrulez;

    public function __construct(string $requrl, array $arrulez)
    {
        $this->requrl = new StringComponent($requrl);
        $this->arrulez = new ArrayComponent($arrulez);
    }

    private function _test_global()
    {
        // ips
        // countries
        // uri
        // post
        // get
        //
    }

    public function get()
    {
        // comprobar filtro global por:
        // request uri
        // get keys
        // get values
        // post keys
        // post values
        // TODO: Implement validate() method.
        //
    }
}