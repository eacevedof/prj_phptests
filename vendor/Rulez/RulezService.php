<?php
namespace Ipblocker\Rulez;

use Ipblocker\IRulez;

final class RulezService
{
    private string $requrl;
    private array $get;
    private array $post;

    public function __construct(string $requrl, array $get=[], array $post=[] )
    {
        $this->requrl = $requrl;
        $this->get = $get;
        $this->post = $post;
    }

}